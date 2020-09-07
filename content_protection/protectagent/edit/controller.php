<?php
namespace content_protection\protectagent\edit;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonPriceAgentAdmin');

		$id = \dash\request::get('id');

		if(!$id || !\dash\coding::decode($id))
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>