<?php
namespace content\doyon;

class view
{
	public static function config()
	{
		// \dash\redirect::to(\dash\url::kingdom());


		\dash\data::page_title(T_("Doyon"));
		\dash\data::page_desc(T_("Get doyon"));

		\dash\data::bodyclass('unselectable');

		$list = \lib\app\doyon::get_raw_list();
		\dash\data::doyonList($list);

		$my_list = \lib\app\doyon::get_my_list();
		\dash\data::myList($my_list);
	}
}
?>