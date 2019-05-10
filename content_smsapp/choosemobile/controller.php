<?php
namespace content_smsapp\choosemobile;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		$data = \lib\db\sms::group_by_togateway();

		if(!$data)
		{
			\dash\redirect::to(\dash\url::here(). '/listsms');
		}

		if(count($data) === 1 && isset($data[0]['togateway']))
		{
			\dash\redirect::to(\dash\url::here(). '/listsms/'. $data[0]['togateway']);
		}

		\dash\data::togateway($data);
	}
}
?>
