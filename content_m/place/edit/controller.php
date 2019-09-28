<?php
namespace content_m\place\edit;


class controller
{
	public static function routing()
	{
		\dash\permission::access('mPlaceEdit');

		$id = \dash\request::get('id');

		if(!$id || !\dash\coding::decode($id))
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>