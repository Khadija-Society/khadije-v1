<?php
namespace content_protection\occasion\allowagent;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonOccasionAdmin');
		$id = \dash\request::get('id');

		if(!$id || !\dash\coding::decode($id))
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>