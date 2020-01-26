<?php
namespace content_agent\home;


class view
{
	public static function config()
	{
		\dash\data::page_title("سامانه مدیریت اعزام مبلغین". \dash\data::xCityTitlePage());


		if(\dash\request::get('city'))
		{
			$args['agent_send.city'] = \dash\request::get('city');
		}

		$dataTable = \lib\app\send::list(null, $args);
		\dash\data::lastAgent($dataTable);


	}


}
?>
