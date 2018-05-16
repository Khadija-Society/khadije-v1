<?php
namespace content_cp\options\cityplace;


class view
{
	public static function config()
	{
		\dash\permission::access('cpOptionCityPlace');
		\dash\data::page_title(T_("Khadije Dashboard"));
		\dash\data::page_special(true);
		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
		\dash\data::cityList(\lib\app\travel::cityList());
		\dash\data::wayList(\lib\app\travel::cityplaceList());
	}
}
?>
