<?php
namespace content_smsapp\report\home;

class controller
{
	public static function routing()
	{

		\dash\permission::access('smsAppSetting');



		if(\dash\request::get('mydata') === 'ansertime')
		{
			$result = \lib\app\sms\report::answer_time();

			\dash\code::jsonBoom($result);
		}

		if(\dash\request::get('getchart') === 'count')
		{
			$result = \lib\app\sms::chart();

			$new_result               = [];
			$new_result['categories'] = json_decode($result['categories'], true);
			$new_result['send']       = json_decode($result['send'], true);
			$new_result['sendpanel']  = json_decode($result['sendpanel'], true);
			$new_result['receive']    = json_decode($result['receive'], true);

			\dash\code::jsonBoom($new_result);
		}

		if(\dash\request::get('getchart') === 'sendstatus')
		{
			$result = \lib\app\sms\report::chart_sendstatus();

			\dash\code::jsonBoom($result);
		}

		if(\dash\request::get('getchart') === 'receivestatus')
		{
			$result = \lib\app\sms\report::chart_receivestatus();
			\dash\code::jsonBoom($result);
		}

		if(\dash\request::get('getchart') === 'recommend')
		{
			$result = \lib\app\sms\report::chart_recommend();
			\dash\code::jsonBoom($result);
		}

		if(\dash\request::get('getchart') === 'group')
		{
			$result = \lib\app\sms\report::chart_group();
			\dash\code::jsonBoom($result);
		}


	}
}
?>