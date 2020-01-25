<?php
namespace content_agent\servant\profiledetail;


class model
{

	public static function post()
	{


		$post                 = [];
		$post['gender']       = \dash\request::post('gender');
		$post['email']        = \dash\request::post('email');
		$post['job']          = \dash\request::post('student') ? 'collegian' : null;
		$post['birthday']     = \dash\request::post('birthday');
		$post['firstname']    = \dash\request::post('name');
		$post['lastname']     = \dash\request::post('lastName');
		$post['nationalcode'] = \dash\request::post('nationalcode');
		$post['father']       = \dash\request::post('father');
		$post['pasportcode']  = \dash\request::post('passport');
		$post['pasportdate']  = \dash\request::post('passportexpire');
		$post['country']      = \dash\request::post('country');
		$post['province']     = \dash\request::post('province');
		$post['city']         = \dash\request::post('city');
		$post['homeaddress']  = \dash\request::post('homeaddress');
		$post['phone']        = \dash\request::post('phone');
		$post['displayname']  = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']      = \dash\request::post('Married');
		$post['zipcode']      = \dash\request::post('zipcode');

		$post['shcode']       = \dash\request::post('shcode');
		$post['child']        = \dash\request::post('child') ? \dash\request::post('child') : null;
		$post['shfrom']       = \dash\request::post('shfrom');
		$post['birthcity']    = \dash\request::post('birthcity');


		\lib\app\myuser::edit($post, ['user_id' => \dash\coding::decode(\dash\request::get('user'))]);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Profile detail was saved"));
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>
