<?php

self::$config['default_payment']                  = 'zarinpal';

self::$config['zarinpal']['status']               = true;

// 1. sobati - checkout to personal
// self::$config['zarinpal']['MerchantID']           = "6df6881c-f054-11e7-b904-000c295eb8fc";

// 2. hoseinpour - checkout to charity
self::$config['zarinpal']['MerchantID']           = "4a254964-3dce-4d46-ab4b-4114137c9115";

self::$config['zarinpal']['Description']          = "Donate";
self::$config['zarinpal']['CallbackURL']          = null;
self::$config['zarinpal']['exchange']             = 1;


// self::$config['asanpardakht']['status']           = true;
self::$config['asanpardakht']['status']           = false;
self::$config['asanpardakht']['MerchantID']       = '3482909';
self::$config['asanpardakht']['MerchantConfigID'] = '2000';
self::$config['asanpardakht']['Username']         = 'KHADIJE3482909';
self::$config['asanpardakht']['Password']         = 'G8B6W4';
self::$config['asanpardakht']['EncryptionKey']    = 's70xvzsS8A1JBCdTsf1lFjGbEYJ/L5Az21GH+JYrwAQ=';
self::$config['asanpardakht']['EncryptionVector'] = 'Ln70tRn69FOW7KHBB3bDMuSRoyvuem8SiixJHeoiykM=';
self::$config['asanpardakht']['MerchantIP']       = '193.176.240.29';
self::$config['asanpardakht']['MerchantName']     = 'KHYRIYE HAZRAT KHDIJE';


self::$config['parsian']['status']                = false;
self::$config['parsian']['LoginAccount']          = '7aXAxXkrWaPer2U53MF1';
self::$config['parsian']['CallBackUrl']           = null;
self::$config['parsian']['exchange']              = null;


self::$config['payir']['status']                  = false;
self::$config['payir']['api']                     = "2556625040aca77c877982b78b9fea93";
self::$config['payir']['redirect']                = null;


self::$config['irkish']['status']                 = null;
self::$config['irkish']['merchantId']             = null;
self::$config['irkish']['revertURL']              = null;
self::$config['irkish']['description']            = null;
self::$config['irkish']['paymentId']              = null;
self::$config['irkish']['sha1']                   = null;



?>