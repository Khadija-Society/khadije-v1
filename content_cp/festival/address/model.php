<?php
namespace content_cp\festival\address;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		$post              = [];


		$post['address']     = \dash\request::post('address');


		$result            = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
