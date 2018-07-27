<?php
namespace content_fp\festival\social;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		$post              = [];
		$post['phone']     = \dash\request::post('phone') ? $_POST['phone'] : null;
		$post['address']   = \dash\request::post('address') ? $_POST['address'] : null;
		$post['email']     = \dash\request::post('email');
		$post['sms']       = \dash\request::post('sms');
		$post['telegram']  = \dash\request::post('telegram');
		$post['facebook']  = \dash\request::post('facebook');
		$post['twitter']   = \dash\request::post('twitter');
		$post['instagram'] = \dash\request::post('instagram');
		$post['linkedin']  = \dash\request::post('linkedin');
		$post['website']   = \dash\request::post('website');
		$result            = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
