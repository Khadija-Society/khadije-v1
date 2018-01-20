<?php


/**
* cofig of zarinpal payment
*/
self::$config['zarinpal']['status']      = true;
self::$config['zarinpal']['MerchantID']  = "6df6881c-f054-11e7-b904-000c295eb8fc";
self::$config['zarinpal']['Description'] = "Donate";
// set the call back is null to redirecto to default dash callback payment
self::$config['zarinpal']['CallbackURL'] = null;
// all amount of this payment * exchange of this payment to change all units to default units of dash
self::$config['zarinpal']['exchange']    = 1;


self::$config['asanpardakht']['status']           = true;
self::$config['asanpardakht']['MerchantID']       = '3482909';
self::$config['asanpardakht']['MerchantConfigID'] = '2000';
self::$config['asanpardakht']['Username']         = 'KHADIJE3482909';
self::$config['asanpardakht']['Password']         = 'G8B6W4';
self::$config['asanpardakht']['EncryptionKey']    = 's70xvzsS8A1JBCdTsf1lFjGbEYJ/L5Az21GH+JYrwAQ=';
self::$config['asanpardakht']['EncryptionVector'] = 'Ln70tRn69FOW7KHBB3bDMuSRoyvuem8SiixJHeoiykM=';
self::$config['asanpardakht']['MerchantIP']       = '37.139.2.244';
self::$config['asanpardakht']['MerchantName']     = 'KHYRIYE HAZRAT KHDIJE';
/**
* config of parsian payment
*/
self::$config['parsian']['status']       = null;
self::$config['parsian']['LoginAccount'] = null;
// set the call back is null to redirecto to default dash callback payment
self::$config['parsian']['CallBackUrl']  = null;
// all amount of this payment * exchange of this payment to change all units to default units of dash
self::$config['parsian']['exchange']     = null;


/**
* config of irkish payment
*/
self::$config['irkish']['status']        = null;
self::$config['irkish']['merchantId']    = null;
// set the call back is null to redirecto to default dash callback payment
self::$config['irkish']['revertURL']     = null;
self::$config['irkish']['description']   = null;
self::$config['irkish']['paymentId']     = null;
self::$config['irkish']['sha1']          = null;



?>