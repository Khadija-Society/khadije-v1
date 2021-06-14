<?php
namespace content_smsapp\conversation;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		if(\dash\request::get('calc') === 'all')
		{
			\dash\temp::set('calcRecord', true);

			$result = [];
			\dash\temp::set('calcRecordLevel', 'awaiting');
			$result['awaiting']            = \content_smsapp\conversation\view::config();

			\dash\temp::set('calcRecordLevel', 'all');
			$result['all']            = \content_smsapp\conversation\view::config();


			$result['answered']            = floatval($result['all']) - floatval($result['awaiting']);

			\dash\code::jsonBoom($result);
		}

	}
}
?>
