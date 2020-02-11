<?php
namespace content_lottery\home;


class view
{
	public static function config()
	{
		\dash\data::page_title("سیستم مدیریت قرعه‌کشی");

		$args = [];

		if(\dash\request::get('type'))
		{
			$args['agent_send.type'] = \dash\request::get('type');
		}

		$dataTable = \lib\app\send::list(null, $args);
		\dash\data::lastAgent($dataTable);


	}


}
?>
