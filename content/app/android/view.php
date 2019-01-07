<?php
namespace content\app\android;

class view
{
	public static function config()
	{
		// \dash\data::page_title(' ');
		// \dash\data::page_desc(' ');
		\dash\data::salavatShomar(\lib\db\salavats::shomar());


	}
}
?>