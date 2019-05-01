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

		if($smsappkey === '1233')
		{
			return true;
		}
		else
		{
			\content_api\v6::no(400, T_("Invalid app key"));
		}

	}


}
?>