<?php
namespace content\l;


class view
{
	public static function config()
	{
		\dash\data::page_title("مسابقات");

		$active_lottery = \lib\app\syslottery::active_list();
		\dash\data::myList($active_lottery);
	}
}
?>
