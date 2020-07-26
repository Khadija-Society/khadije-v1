<?php
namespace content_m\festival;

class controller
{


	public static function check_festival_id()
	{
		if(!\dash\request::get('id'))
		{
			\dash\header::status(404, T_("Id not set"));
		}

		\dash\data::dataRow(\lib\app\festival::get(\dash\request::get('id')));
		\dash\data::dataRowFestivalDetails(\dash\data::dataRow());
		if(!\dash\data::dataRow())
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>