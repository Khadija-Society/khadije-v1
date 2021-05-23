<?php
namespace content_smsapp\choosemobile;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		\dash\redirect::to(\dash\url::here(). '/conversation');


		$child = \dash\url::child();

		if($child && in_array($child, ['listsms']))
		{
			\dash\open::get();
		}

		if(!$child)
		{
			$child = 'listsms';
		}

		\dash\data::myUrlChild($child);

		$data = \lib\db\sms::group_by_togateway();

		if(!$data)
		{
			\dash\redirect::to(\dash\url::here(). '/'. $child);
		}

		if(count($data) === 1 && isset($data[0]['togateway']))
		{
			\dash\redirect::to(\dash\url::here(). '/'. $child. '/'. $data[0]['togateway']);
		}

		\dash\data::togateway($data);
	}
}
?>
