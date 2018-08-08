<?php
namespace content_cp\festival\social;


class model
{
	public static function post()
	{
		$social              = [];
		$social['email']     = \dash\request::post('email');
		$social['sms']       = \dash\request::post('sms');
		$social['telegram']  = \dash\request::post('telegram');
		$social['facebook']  = \dash\request::post('facebook');
		$social['twitter']   = \dash\request::post('twitter');
		$social['instagram'] = \dash\request::post('instagram');
		$social['linkedin']  = \dash\request::post('linkedin');
		$social['sapp']      = \dash\request::post('sapp');
		$social['eitaa']     = \dash\request::post('eitaa');
		$social['aparat']    = \dash\request::post('aparat');

		$post            = [];
		$post['website'] = \dash\request::post('website');
		$post['social']  = json_encode($social, JSON_UNESCAPED_UNICODE);

		$result = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
