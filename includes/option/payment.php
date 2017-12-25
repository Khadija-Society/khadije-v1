<?php


/**
* cofig of zarinpal payment
*/
self::$config['zarinpal']['status']      = null;
self::$config['zarinpal']['MerchantID']  = null;
self::$config['zarinpal']['Description'] = null;
// set the call back is null to redirecto to default dash callback payment
self::$config['zarinpal']['CallbackURL'] = null;
// all amount of this payment * exchange of this payment to change all units to default units of dash
self::$config['zarinpal']['exchange']    = null;


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