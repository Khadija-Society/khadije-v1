<?php
require_once('social.php');
require_once('payment.php');
require_once('sms.php');

if(!defined('db_log_name'))
{
	define('db_log_name', 'khadije_log');
}
/**
@ In the name Of Allah
* The base configurations of the khadije.
*/
self::$language =
[
	'default' => 'fa',
	// 'list'    => ['fa','en',],
	'list'    => ['fa'],
];

// fix url and redirect
// http://khadije.net
// http://khadije.org
// to https://khadije.com
self::$url['tld']                   = 'com';
self::$url['protocol']              = 'https';


self::$config['site']['title']  = "Khadije Charity";
self::$config['site']['desc']   = "Executor of first pilgrimage to the Ahl al-Bayt";
self::$config['site']['slogan'] = "Executor of first pilgrimage to the Ahl al-Bayt";

self::$config['visitor']              = true;

self::$config['debug']              = false;
self::$config['coming']             = false;
self::$config['redirect']           = 'a';


self::$config['favicon']['version'] = 4;


/**
 * call kavenegar template
 */
self::$config['enter']['call']                = true;
self::$config['enter']['call_template_fa'] = 'khadije-fa';
self::$config['enter']['call_template_en'] = 'khadije-en';

/**
 * first signup url
 * main redirect url . signup redirect url
 */
self::$config['enter']['singup_username']     = false;
self::$config['enter']['singup_redirect']     = 'u';



/**
 * list of units
 */
self::$config['units'] =
[
	1 =>
	[
		'title' => 'toman',
		'desc'  => "Toman",
	],

	2 =>
	[
		'title' => 'dollar',
		'desc'  => "$",
	],
];
// the unit id for default
self::$config['default_unit'] = 1;
// force change unit to this unit
self::$config['force_unit']   = 1;

/**
 * transaction code
 */
self::$config['transactions_code'][100] = "invoice:store";
self::$config['transactions_code'][150] = "promo:ref";


self::$config['enter']['verify_telegram'] = false;
self::$config['enter']['verify_sms']      = true;
self::$config['enter']['verify_call']     = true;
self::$config['enter']['verify_sendsms']  = false;


?>