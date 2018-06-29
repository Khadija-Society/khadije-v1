<?php
namespace content_fp\festival\file;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');
		\dash\notif::warn("Not ready");
		return false;
		$result           = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
