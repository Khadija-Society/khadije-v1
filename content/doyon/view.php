<?php
namespace content\doyon;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Doyon"));
		\dash\data::page_desc(T_("Get doyon"));

		\dash\data::bodyclass('unselectable');

		$list = \lib\app\doyon::get_raw_list();
		\dash\data::doyonList($list);
	}
}
?>