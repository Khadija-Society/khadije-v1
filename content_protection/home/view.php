<?php
namespace content_protection\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("System manage protection users"));

		$args =
		[
			'sort'       => 'id',
			'order'      => 'desc'
		];
		$dataTable = \lib\app\protectagent::list(null, $args);
		\dash\data::lastAgent($dataTable);


		$dashboardDetail = \lib\app\protectiontype::dashboard();
		\dash\data::dashboardDetail($dashboardDetail);

	}

}
?>
