<?php
namespace content\manager;


class view extends \content_support\ticket\contact_ticket\view
{

	public static function config()
	{
		\dash\data::page_title(T_("Contact with manager"));
		\dash\data::page_desc(T_("We do our best to improve khadije's service quality."));
		\dash\app\template::find();
		\dash\data::datarow(\dash\app\template::$datarow);
		self::codeurl();
	}
}
?>