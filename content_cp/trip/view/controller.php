<?php
namespace content_cp\trip\view;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpTripEdit');

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{

		}
		else
		{
			\dash\header::status(403, T_("Id not found"));
		}
	}
}
?>
