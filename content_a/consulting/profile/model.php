<?php
namespace content_a\consulting\profile;


class model
{

	public static function post()
	{
		$post                    = [];
		//$post['gender']          = \dash\request::post('gender') ;
		//$post['email']           = \dash\request::post('email');
		//$post['birthday']        = \dash\request::post('birthday');
		$post['firstname']       = \dash\request::post('name');
		$post['lastname']        = \dash\request::post('lastName');
		//$post['nationalcode']    = \dash\request::post('nationalcode');
		//$post['father']          = \dash\request::post('father');
		//$post['pasportcode']     = \dash\request::post('passport');
		//$post['pasportdate']     = \dash\request::post('passportexpire');
		//$post['country']         = \dash\request::post('country');
		//$post['province']        = \dash\request::post('province');
		//$post['city']            = \dash\request::post('city');
		//$post['homeaddress']     = \dash\request::post('homeaddress');
		//$post['phone']           = \dash\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['job']             = \dash\request::post('student') ? 'collegian' : null;
		//$post['married']         = \dash\request::post('Married') ;
		//$post['zipcode']         = \dash\request::post('zipcode');

		\lib\app\myuser::edit($post);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your detail was saved"));
			\dash\redirect::to(\dash\url::here(). '/consulting/detail?id='. \dash\request::get('id'));
		}

	}
}
?>
