<?php
return array(
    // set your paypal credential
    'client_id' => 'AcR0Ik3OmgzkhUVki0Mdc-jw6_fpoQhekfuz2RjBAOzyVOpw9vmUuLPOwMrken82eANf3TP4VwLmWwBV',
    'secret' => 'EFttcPCfKGZ_jApfyWoKeicb7JNEGgQuUNVqXU5PhagtmQIPYHENUWE7sm4aq4G1ORSSgo41JbOBSdlJ',

    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
