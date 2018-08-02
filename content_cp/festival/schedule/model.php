<?php
namespace content_cp\festival\schedule;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		$post              = [];


		$post['email']     = \dash\request::post('email');
		$post['sms']       = \dash\request::post('sms');
		$post['telegram']  = \dash\request::post('telegram');
		$post['facebook']  = \dash\request::post('facebook');
		$post['twitter']   = \dash\request::post('twitter');
		$post['instagram'] = \dash\request::post('instagram');
		$post['linkedin']  = \dash\request::post('linkedin');
		$post['website']   = \dash\request::post('website');

		$phone1            = \dash\request::post('phone1');
		$phone2            = \dash\request::post('phone2');
		$post['phone']     = ['phone1' => $phone1, 'phone2' => $phone2];
		$post['phone']     = json_encode($post['phone'], JSON_UNESCAPED_UNICODE);

		$result            = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
