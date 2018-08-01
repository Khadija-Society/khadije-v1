<?php
namespace content_cp;

class controller
{
	public static function routing()
	{

	}

	public static function check_festival_id()
	{
		if(!\dash\request::get('id'))
		{
			\dash\header::status(404, T_("Id not set"));
		}

		\dash\data::dataRow(\lib\app\festival::get(\dash\request::get('id')));

		if(!\dash\data::dataRow())
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>