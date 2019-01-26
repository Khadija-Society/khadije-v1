<?php
namespace content\karbala;


class model
{

	public static function post()
	{
		if(!\dash\request::post('accept'))
		{
			\dash\notif::error("لطفا تایید کنید که این ثبت‌نام به منزله اعزام نیست", 'accept');
			return false;
		}
		$post                    = [];
		$post['mobile']          = \dash\request::post('mobile') ;
		$post['gender']          = \dash\request::post('gender') ;
		// $post['email']           = \dash\request::post('email');
		// $post['job']             = \dash\request::post('student') ? 'collegian' : null;
		$post['birthday']        = \dash\request::post('birthday');
		$post['firstname']       = \dash\request::post('name');
		$post['lastname']        = \dash\request::post('lastName');
		$post['nationalcode']    = \dash\request::post('nationalcode');
		$post['father']          = \dash\request::post('father');
		// $post['pasportcode']     = \dash\request::post('passport');
		// $post['pasportdate']     = \dash\request::post('passportexpire');
		$post['country']         = \dash\request::post('country');
		$post['province']        = \dash\request::post('province');
		$post['city']            = \dash\request::post('city');
		$post['homeaddress']     = \dash\request::post('homeaddress');
		$post['phone']           = \dash\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \dash\request::post('Married') ;
		// $post['zipcode']         = \dash\request::post('zipcode');

		\lib\app\karbalauser::add($post);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your signup complete"));
			\dash\redirect::to(\dash\url::here(). '/karbala');
		}

	}
}
?>
