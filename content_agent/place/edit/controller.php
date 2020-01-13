<?php
namespace content_agent\place\edit;


class controller
{
	public static function routing()
	{
		\dash\permission::access('ContentMokebEditPlace');

		$id = \dash\request::get('id');

		if(!$id || !\dash\coding::decode($id))
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>