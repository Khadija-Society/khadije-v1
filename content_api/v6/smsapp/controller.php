<?php
namespace content_api\v6\smsapp;


class controller
{
	public static function routing()
	{

		if(!\dash\request::is('post'))
		{
			\content_api\v6::no(404);
		}

		self::check_smsappkey();

		self::check_allow_gateway();

		\lib\app\sms::lastconnected(true);

		$detail    = [];

		$directory = \dash\url::directory();

		if($directory === 'v6/smsapp/dashboard')
		{
			$detail = \content_api\v6\smsapp\dashboard::get();
		}
		// elseif($directory === 'v6/smsapp/new')
		// {
		// 	$detail = \content_api\v6\smsapp\newsms::add_new_sms();
		// }
		// elseif($directory === 'v6/smsapp/notsent')
		// {
		// 	$detail = \content_api\v6\smsapp\notsent::get();
		// }
		// elseif($directory === 'v6/smsapp/queue')
		// {
		// 	$detail = \content_api\v6\smsapp\queue::get();
		// }
		// elseif($directory === 'v6/smsapp/sent')
		// {
		// 	$detail = \content_api\v6\smsapp\sent::set();
		// }
		elseif($directory === 'v6/smsapp/status')
		{
			$detail = \content_api\v6\smsapp\status::set();
		}
		elseif($directory === 'v6/smsapp/setting')
		{
			$detail = \content_api\v6\smsapp\setting::get();
		}
		// elseif($directory === 'v6/smsapp/sync')
		// {
		// 	$detail = \content_api\v6\smsapp\sync::fire();
		// }
		elseif($directory === 'v6/smsapp/sync2')
		{
			if(self::isBusy())
			{
				\dash\log::set('apiSMSAPPISBusy');
				\dash\notif::error('apiSMSAPPISBusy');
				return false;
			}

			register_shutdown_function(['\\content_api\\v6\\smsapp\\controller', 'isBusy'], false);

			self::isBusy(true);

			$detail = \content_api\v6\smsapp\sync::fire2();

			self::isBusy(false);
		}
		else
		{
			\content_api\v6::no(404);
		}


		\content_api\v6::bye($detail);

	}


	public static function isBusy($_mode = null)
	{
		$file = __DIR__ .'/isBusy.me.conf';

		if(is_null($_mode))
		{
			return file_exists($file);
		}

		if($_mode === true)
		{
			@file_put_contents($file, date("Y-m-d H:i:s"));
			return;
		}

		if($_mode === false)
		{
			if(file_exists($file))
			{
				unlink($file);
			}

		}
	}


	private static function check_smsappkey()
	{
		$smsappkey = \dash\header::get('smsappkey');

		if(!trim($smsappkey))
		{
			\content_api\v6::no(400, T_("Appkey not set"));
		}

		if($smsappkey === 'e2c998bbb48931f40a0f7d1cba53434f')
		{
			return true;
		}
		else
		{
			\content_api\v6::no(400, T_("Invalid app key"));
		}

	}

	public static function check_allow_gateway()
	{
		// check gateway to not run this application in other device
		$gateway = \dash\header::get('gateway');
		$gateway = \dash\utility\filter::mobile($gateway);

		$check_allow_gateway =
		[
			'989109610612', // reza
			'989357269759', // javad
			'989127522690', // sobati
			'989127510991', // khalili
			'989123511113', // haram
			'989101571711', // khadije 2
			// '989195191378', // my son
		];

		if(in_array($gateway, $check_allow_gateway))
		{
			// lock on this platoon
			\lib\app\platoon\tools::lock($gateway);

			return true;
		}
		else
		{
			\content_api\v6::no(400, T_("Invalid mobile for gateway"));
			return false;
		}
	}


	public static function status($_set = null)
	{
		return \lib\app\sms::status($_set);

	}


}
?>