<?php
namespace content_m\trip\profile;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Set user profile"));
		\dash\data::page_desc(' ');
		\content_a\profile\view::static_var();
	}
}
?>
