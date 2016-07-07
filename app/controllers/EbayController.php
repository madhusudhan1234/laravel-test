<?php

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;


class EbayController extends \BaseController
{

    /**
     * @var ApiContext
     */
    private $_api_context;

    /**
     * EbayController constructor.
     */
    public function __construct()
    {
        //$ebay_conf = Config::get('ebay');
        //$this->_api_context = new FindingService(new ($ebay_conf['dev_id'], $ebay_conf['app_id'], $ebay_conf['cert_id'], $ebay_conf['auth_token']));
        //$this->_api_context->setConfig($ebay_conf['settings']);
    }

    public function addToStore()
    {
        $config = Config::get('ebay');

        $request = new Types\AddFixedPriceItemRequestType();

        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $config['sandbox']['userToken'];
        //dd($request);
        $item = new Types\ItemType();

        $item->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
        //dd(\Input::get('quantity'));
        $item->Quantity = (Integer)\Input::get('quantity');

        $item->ListingDuration = Enums\ListingDurationCodeType::C_GTC;

        $item->StartPrice = new Types\AmountType(['value' => (Double)\Input::get('price')]);

        $item->BestOfferDetails = new Types\BestOfferDetailsType();
        $item->BestOfferDetails->BestOfferEnabled = true;
        $i = Input::get('price');
        $item->ListingDetails = new Types\ListingDetailsType();
        $item->ListingDetails->BestOfferAutoAcceptPrice = new Types\AmountType(['value' => (Double)$i - 1]);
        $item->ListingDetails->MinimumBestOfferPrice = new Types\AmountType(['value' => (Double)$i - 1.5]);

        $item->Title = (String)\Input::get('productname');

        $item->Description = (String)\Input::get('description');

        $item->SKU = 'ABC-001';
        $item->Country = 'AU';
        $item->Location = 'Norfolk Island';
        $item->PostalCode = '2899';

        /**
         * This is a required field.
         */
        $item->Currency = 'USD';
        /**
         * Display a picture with the item.
         */
        $item->PictureDetails = new Types\PictureDetailsType();
        $item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;
        $item->PictureDetails->PictureURL = ['http://lorempixel.com/1500/1024/abstract'];

        $item->PrimaryCategory = new Types\CategoryType();
        $item->PrimaryCategory->CategoryID = '29792';
        /**
         * For the category that we are listing in the value of 1000 is for Brand New.
         */
        $item->ConditionID = 1000;

        $item->PaymentMethods = [
            'PayPal'
        ];
        $item->PayPalEmailAddress = 'example@example.com';
        $item->DispatchTimeMax = 1;
        //shipping details
        $item->ShippingDetails = new Types\ShippingDetailsType();
        $item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;

        //dd($item);
        $shippingService = new Types\ShippingServiceOptionsType();
        //dd($shippingService);
        $shippingService->ShippingServicePriority = 1;
        $shippingService->ShippingService = 'Other';
        $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 3.00]);
        $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 2.00]);
        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
        //dd($shippingService);
        //second shipping
        $shippingService = new Types\ShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 2;
        $shippingService->ShippingService = 'USPSParcel';
        $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 3.00]);
        $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 2.00]);
        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
        //return policy
        $item->ReturnPolicy = new Types\ReturnPolicyType();
        $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';
        $item->ReturnPolicy->RefundOption = 'MoneyBack';
        $item->ReturnPolicy->ReturnsWithinOption = 'Days_14';
        $item->ReturnPolicy->ShippingCostPaidByOption = 'Buyer';

        $request->Item = $item;
        dd($request);

        $service = new Services\TradingService(array(
            'apiVersion' => $config['tradingApiVersion'],
            'devId' => $config['sandbox']['devId'],
            'appId' => $config['sandbox']['appId'],
            'certId' => $config['sandbox']['certId'],
            'siteId' => Constants\SiteIds::US,
            'sandbox' => true
        ));

        // $response = $service->addFixedPriceItem($request);
        //dd($response);
        /*if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                //  dd($response);
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );
            }
        }
        if ($response->Ack !== 'Failure') {
            printf(
                "The item was listed to the eBay Sandbox with the Item number %s\n",
                $response->ItemID
            );
        }*/

    }

    public function time()
    {
        $config = Config::get('ebay');
        $service = new Services\TradingService(array(
            'apiVersion' => $config['tradingApiVersion'],
            'siteId' => Constants\SiteIds::AU,
            'sandbox' => true
        ));

        $request = new Types\GeteBayOfficialTimeRequestType();

        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $config['sandbox']['userToken'];

        $response = $service->geteBayOfficialTime($request);
        if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );
            }
        }
        if ($response->Ack !== 'Failure') {
            printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));
        }
    }
}
