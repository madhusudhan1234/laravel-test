<?php

use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Trading\Enums\GalleryTypeCodeType;
use DTS\eBaySDK\Trading\Enums\ListingDurationCodeType;
use DTS\eBaySDK\Trading\Enums\ListingTypeCodeType;
use DTS\eBaySDK\Trading\Enums\SeverityCodeType;
use DTS\eBaySDK\Trading\Enums\ShippingTypeCodeType;
use DTS\eBaySDK\Trading\Services;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types;
use DTS\eBaySDK\Trading\Enums;
use DTS\eBaySDK\Trading\Types\AddFixedPriceItemRequestType;
use DTS\eBaySDK\Trading\Types\AmountType;
use DTS\eBaySDK\Trading\Types\BestOfferDetailsType;
use DTS\eBaySDK\Trading\Types\CategoryType;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GeteBayOfficialTimeRequestType;
use DTS\eBaySDK\Trading\Types\ItemType;
use DTS\eBaySDK\Trading\Types\ListingDetailsType;
use DTS\eBaySDK\Trading\Types\PictureDetailsType;
use DTS\eBaySDK\Trading\Types\ReturnPolicyType;
use DTS\eBaySDK\Trading\Types\ShippingDetailsType;
use DTS\eBaySDK\Trading\Types\ShippingServiceOptionsType;


/**
 * Class EbayController
 */
class EbayController extends \BaseController
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var TradingService
     */
    private $service;

    /**
     * EbayController constructor.
     */
    public function __construct()
    {
        $this->config = Config::get('ebay');

        $this->service = new TradingService(array(
            'apiVersion' => $this->config['tradingApiVersion'],
            'devId' => $this->config['sandbox']['devId'],
            'appId' => $this->config['sandbox']['appId'],
            'certId' => $this->config['sandbox']['certId'],
            'siteId' => Constants\SiteIds::US,
            'sandbox' => true
        ));
    }


    /**
     * Method To Store the Product in Ebay
     */
    public function addToStore()
    {
        $request = new AddFixedPriceItemRequestType();
        $request->RequesterCredentials = new CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $this->config['sandbox']['userToken'];
        $item = $this->itemType();
        $this->pictureDetails($item);
        $this->itemCategoryType($item);
        $item->ShippingDetails = new ShippingDetailsType();
        $item->ShippingDetails->ShippingType = ShippingTypeCodeType::C_FLAT;
        $shippingService = $this->shippingService($item);
        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
        $this->returnPolicy($item);
        $request->Item = $item;
        $response = $this->service->addFixedPriceItem($request);
        if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );
            }
        }

        if ($response->Ack !== 'Failure') {
            return Redirect::to('/')->with('message', 'The item was listed to the eBay Sandbox with the Item number ' . $response->ItemID);
        }

    }


    /**
     * @return mixed
     */
    public function time()
    {
        $request = new GeteBayOfficialTimeRequestType();
        $request->RequesterCredentials = new CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $this->config['sandbox']['userToken'];

        $response = $this->service->geteBayOfficialTime($request);
        if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );
            }
        }
        if ($response->Ack !== 'Failure') {
            return Redirect::to('/')->with('message', 'Current Ebay Time: ' . $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));
        }
    }

    /**
     * @param $item
     * @return ShippingServiceOptionsType
     */
    public function shippingService($item)
    {
        $shippingService = new ShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 1;
        $shippingService->ShippingService = 'Other';
        $shippingService->ShippingServiceCost = new AmountType(['value' => 3.00]);
        $shippingService->ShippingServiceAdditionalCost = new AmountType(['value' => 2.00]);
        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
        $shippingService = new ShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 2;
        $shippingService->ShippingService = 'USPSParcel';
        $shippingService->ShippingServiceCost = new AmountType(['value' => 3.00]);
        $shippingService->ShippingServiceAdditionalCost = new AmountType(['value' => 2.00]);
        return $shippingService;
    }

    /**
     * Return Policy of Item
     * 
     * @param $item
     */
    public function returnPolicy($item)
    {
        $item->ReturnPolicy = new ReturnPolicyType();
        $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';
        $item->ReturnPolicy->RefundOption = 'MoneyBack';
        $item->ReturnPolicy->ReturnsWithinOption = 'Days_14';
        $item->ReturnPolicy->ShippingCostPaidByOption = 'Buyer';
    }

    /**
     *
     * @return ItemType
     */
    public function itemType()
    {
        $item = new ItemType();
        $item->ListingType = ListingTypeCodeType::C_FIXED_PRICE_ITEM;
        $item->Quantity = (Integer)Input::get('quantity');
        $item->ListingDuration = ListingDurationCodeType::C_GTC;
        $item->StartPrice = new AmountType(['value' => (Double)Input::get('price')]);
        $item->BestOfferDetails = new BestOfferDetailsType();
        $item->BestOfferDetails->BestOfferEnabled = true;
        $i = Input::get('price');
        $item->ListingDetails = new ListingDetailsType();
        $item->ListingDetails->BestOfferAutoAcceptPrice = new AmountType(['value' => (Double)$i - 1]);
        $item->ListingDetails->MinimumBestOfferPrice = new AmountType(['value' => (Double)$i - 1.5]);
        $item->Title = (String)Input::get('productname');
        $item->Description = (String)Input::get('description');
        $item->SKU = 'ABC-001';
        $item->Country = 'AU';
        $item->Location = 'Norfolk Island';
        $item->PostalCode = '2899';
        $item->Currency = 'USD';
        return $item;
    }

    /**
     * Method For PictureDetailsType
     *
     * @param $item
     */
    public function pictureDetails($item)
    {
        $item->PictureDetails = new PictureDetailsType();
        $item->PictureDetails->GalleryType = GalleryTypeCodeType::C_GALLERY;
        $item->PictureDetails->PictureURL = ['http://lorempixel.com/1500/1024/abstract'];
    }

    /**
     * Item Category New,Used and Payment method for Item
     *
     * @param $item
     */
    public function itemCategoryType($item)
    {
        $item->PrimaryCategory = new CategoryType();
        $item->PrimaryCategory->CategoryID = '29792';
        $item->ConditionID = 1000;
        $item->PaymentMethods = [
            'PayPal'
        ];
        $item->PayPalEmailAddress = 'example@example.com';
        $item->DispatchTimeMax = 1;
    }

}
