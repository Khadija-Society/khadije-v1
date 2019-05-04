<?php
namespace content_m\admincontact\edit;

class controller
{

	public static function routing()
	{
		\dash\permission::access('cpAdminContactChangeStatus');

		\dash\redirect::to(\dash\url::kingdom(). '/support/ticket?access=all&status=all&q='. T_("Admin contact"));
		return;


		// $id = \dash\request::get('id');

		// if(!$id || !\dash\coding::is($id))
		// {
		// 	\dash\header::status(404, T_("Invalid id"));
		// }
	}
}
?>