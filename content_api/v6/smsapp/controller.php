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


		$detail    = [];

		$directory = \dash\url::directory();

		if($directory === 'v6/smsapp/dashboard')
		{
			$detail = \content_api\v6\smsapp\dashboard::get();
		}
		elseif($directory === 'v6/smsapp/new')
		{
			$detail = \content_api\v6\smsapp\newsms::add_new_sms();
		}
		elseif($directory === 'v6/smsapp/notsent')
		{
			$detail = \content_api\v6\smsapp\notsent::get();
		}
		elseif($directory === 'v6/smsapp/queue')
		{
			$detail = \content_api\v6\smsapp\queue::get();
		}
		elseif($directory === 'v6/smsapp/sent')
		{
			$detail = \content_api\v6\smsapp\sent::set();
		}
		elseif($directory === 'v6/smsapp/status')
		{
			$detail = \content_api\v6\smsapp\status::set();
		}
		else
		{
			\content_api\v6::no(404);
		}

		\content_api\v6::bye($detail);

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
			'sobati', // sobati need to get mobile
			'khalili', // khalili need to get mobile
		];

		if(in_array($gateway, $check_allow_gateway))
		{
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
		$addr = root.'includes/lib/app/smsapp.me.txt';
		$addr = \autoload::fix_os_path($addr);

		if($_set === false)
		{
			$status =
			[
				'status' => false,
			];

			$status = json_encode($status, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

			\dash\file::write($addr, $status);
			return true;
		}
		elseif($_set === true)
		{
			$status =
			[
				'status' => true,
			];

			$status = json_encode($status, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

			\dash\file::write($addr, $status);
			return true;
		}

		if(is_file($addr))
		{
			$get = \dash\file::read($addr);
			$get = json_decode($get, true);
			if(isset($get['status']) && $get['status'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$status =
			[
				'status' => true,
			];

			$status = json_encode($status, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

			\dash\file::write($addr, $status);
			return true;
		}

	}


}
?>