<?php
namespace content_cp\festival\address;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		$post            = [];
		$post['address'] = \dash\request::post('address');
		$post['address1'] = \dash\request::post('address1');
		$post['length']  = \dash\request::post('length');
		$post['width']   = \dash\request::post('width');

		$update['address'] = json_encode($post, JSON_UNESCAPED_UNICODE);

		$result            = \lib\app\festival::edit($update, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
