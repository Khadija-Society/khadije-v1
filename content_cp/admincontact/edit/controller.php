<?php
namespace content_cp\admincontact\edit;

class controller
{

	public static function routing()
	{
		\dash\permission::access('cpDelneveshteEdit');

		$id = \dash\request::get('id');

		if(!$id || !\dash\coding::is($id))
		{
			\dash\header::status(404, T_("Invalid id"));
		}
	}
}
?>