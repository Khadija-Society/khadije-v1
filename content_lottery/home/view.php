<?php
namespace content_lottery\home;


class view
{
	public static function config()
	{
		\dash\data::page_title("سیستم مدیریت قرعه‌کشی");

		$active_lottery = \lib\app\syslottery::boy_list();
		\dash\data::myList($active_lottery);

	}


}
?>
