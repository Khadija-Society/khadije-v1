<?php
namespace content\l\signup;


class model
{

	public static function post()
	{

		if(!\dash\request::post('accept'))
		{
			\dash\notif::error("لطفا شرایط و قوانین را تایید کنید", 'accept');
			return false;
		}

		$post                    = [];
		$post['mobile']          = \dash\request::post('mobile') ;
		$post['lottery_id']          = \dash\data::lotteryId();
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
		// $post['country']         = \dash\request::post('country');
		// $post['province']        = \dash\request::post('province');
		$post['city']            = \dash\request::post('city');
		$post['homeaddress']     = \dash\request::post('homeaddress');
		$post['phone']           = \dash\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \dash\request::post('Married') ;
		// $post['zipcode']         = \dash\request::post('zipcode');

		\lib\app\lottery_user::add($post);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok('ثبت ‌نام شما با موفقیت انجام شد.'. ' '. 'لطفا منتظر اعلام نتایج قرعه‌کشی بمانید', ['alerty' => true]);

			$_SESSION['LOTTERY_NEW_SIGNUP'] = true;
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>
