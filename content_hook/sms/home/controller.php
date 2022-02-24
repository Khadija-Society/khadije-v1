<?php
namespace content_hook\sms\home;

class controller
{
	public static function routing()
	{
		if(\dash\url::child() === 'a7cddcc2d626d3d4807e2cbd23129be3')
		{
			$messageid = \dash\request::request('messageid');
			$from      = \dash\request::request('from');
			$to        = \dash\request::request('to');
			$message   = \dash\request::request('message');

			if($from && $message)
			{
				\lib\app\platoon\tools::lock('10006121');

				$args =
				[
					'md5'        => null,
					'from'       => $from,
					'text'       => $message,
					'date'       => date("Y-m-d H:i:s"),
					'brand'      => null,
					'md5'        => null,
					'MD5'        => null,
					'model'      => null,
					'simcart'    => null,
					'smsMessage' => null,
					'userdata'   => null,

				];

				$sms_id = \content_api\v6\smsapp\newsms::multi_add_new_sms($args);


				\dash\log::set('smsHook', ['my_data' => $sms_id]);
			}



			\dash\code::jsonBoom('Hi Hook!');
		}
		else
		{
			\dash\header::status(404, ':/');
		}
	}
}
?>