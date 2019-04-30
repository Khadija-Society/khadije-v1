<?php
namespace content_cp\festival\usercourse;


class model
{
	public static function post()
	{

		$post           = [];
		$post['status'] = \dash\request::post('status');
		$post['desc']   = \dash\request::post('desc');

		$result = \lib\db\festivalusers::update($post, \dash\coding::decode(\dash\request::get('festivaluser')));

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Data successfully updated"));
			\dash\redirect::pwd();
		}
	}
}
?>
