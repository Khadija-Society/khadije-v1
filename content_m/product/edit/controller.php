<?php
namespace content_m\product\edit;


class controller
{
	public static function routing()
	{
		\dash\permission::access('mProductEdit');

		$id = \dash\request::get('id');

		if(!$id || !\dash\coding::decode($id))
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>