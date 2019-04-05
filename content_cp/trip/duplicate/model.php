<?php
namespace content_cp\trip\duplicate;


class model
{


	public static function post()
	{

		$id   = \dash\request::post('id');
		$copy = \dash\request::post('copy');

		if($id !== \dash\request::get('id') || !in_array($copy, ['qom', 'mashhad', 'karbala']))
		{
			\dash\notif::error(T_("Dont!"));
			return false;
		}

		\lib\app\travel::make_duplicate($id, $copy);

		if(\dash\engine\process::status())
		{
			\dash\log::set('createDuplicateFromTravel', ['code' => \dash\request::get('id'), 'copyTo' => $copy]);
			\dash\notif::ok(T_("Travel duplicated"));
			\dash\redirect::pwd();
		}


	}
}
?>
