<?php
namespace content_cp\festival\phone;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		$post              = [];
		$phone1            = \dash\request::post('phone1');
		$phone2            = \dash\request::post('phone2');
		$phone3            = \dash\request::post('phone3');
		$post['phone']     = ['phone1' => $phone1, 'phone2' => $phone2, 'phone3' => $phone3];

		$post['phone']     = json_encode($post['phone'], JSON_UNESCAPED_UNICODE);

		$result            = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
