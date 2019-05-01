<?php
namespace content_api\v6\smsapp;


class controller
{
	public static function routing()
	{
		self::check_smsappkey();

		if(\dash\url::directory() === 'v6/smsapp/new' && \dash\request::is('post'))
		{
			$detail = \content_api\v6\smsapp\newsms::add_new_sms();
			\content_api\v6::bye($detail);
		}
		elseif(\dash\url::directory() === 'v6/smsapp/queue' && \dash\request::is('post'))
		{
			$detail = self::queue();
			\content_api\v6::bye($detail);
		}
		else
		{
			\content_api\v6::no(404);
		}

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