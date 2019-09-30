<?php
namespace content_mokeb\add;


class model
{

	public static function post()
	{
		if(\dash\request::post('forceexit'))
		{
			\lib\app\mokebuser::forceexit(\dash\request::get('cnationalcode'), \dash\request::get('position'));
			if(\dash\request::get('cnationalcode'))
			{
				\dash\redirect::pwd();
			}
			else
			{
				\dash\redirect::to(\dash\url::that());
			}
			return;
		}

		$post                    = [];
		$post['mobile']          = \dash\request::post('mobile') ;
		$post['gender']          = \dash\request::post('gender') ;
		// $post['email']           = \dash\request::post('email');
		// $post['job']             = \dash\request::post('student') ? 'collegian' : null;
		// $post['birthday']        = \dash\request::post('birthday');
		$post['firstname']       = \dash\request::post('name');
		$post['lastname']        = \dash\request::post('lastName');
		if(\dash\request::get('cnationalcode'))
		{
			$post['nationalcode']    = \dash\request::get('cnationalcode');
		}
		else
		{
			$post['nationalcode']    = \dash\request::post('nationalcode');
		}
		// $post['father']          = \dash\request::post('father');
		// $post['pasportcode']     = \dash\request::post('passport');
		// $post['pasportdate']     = \dash\request::post('passportexpire');
		// $post['country']         = \dash\request::post('country');
		// $post['province']        = \dash\request::post('province');
		$post['city']            = \dash\request::post('city');
		// $post['homeaddress']     = \dash\request::post('homeaddress');
		// $post['phone']           = \dash\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \dash\request::post('Married') ;
		// $post['zipcode']         = \dash\request::post('zipcode');
		$post['position']         = \dash\request::get('position');

		\lib\app\mokebuser::add($post, ['place' => \dash\url::child()]);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok('پذیرش انجام شد.');


			\dash\redirect::to(\dash\url::that(). '?print=auto&cnationalcode='. \dash\request::get('cnationalcode'));
		}

	}
}
?>
