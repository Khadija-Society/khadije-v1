<?php
namespace content\l\signup;


class model
{

	public static function post()
	{
		if(\dash\data::myLottery_agreemessage())
		{
			if(!\dash\request::post('accept'))
			{
				\dash\notif::error("لطفا شرایط و قوانین را تایید کنید", 'accept');
				return false;
			}
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
		$post['desc']        = \dash\request::post('desc');
		$post['city']            = \dash\request::post('city');
		$post['education']            = \dash\request::post('education');
		$post['homeaddress']     = \dash\request::post('homeaddress');
		$post['phone']           = \dash\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \dash\request::post('Married') ;
		// $post['zipcode']         = \dash\request::post('zipcode');

		$max_upload       = 50 * 1024 * 1024;
		$max_upload_image = 50 * 1024 * 1024;

		$imagefile1 = \dash\app\file::upload_quick('imagefile1', ['max_upload' => $max_upload_image]);
		if($imagefile1)
		{
			$post['imagefile1'] = $imagefile1;
		}

		$imagefile2 = \dash\app\file::upload_quick('imagefile2', ['max_upload' => $max_upload_image]);
		if($imagefile2)
		{
			$post['imagefile2'] = $imagefile2;
		}

		$imagefile3 = \dash\app\file::upload_quick('imagefile3', ['max_upload' => $max_upload_image]);
		if($imagefile3)
		{
			$post['imagefile3'] = $imagefile3;
		}


		$videofile1 = \dash\app\file::upload_quick('videofile1', ['max_upload' => $max_upload]);
		if($videofile1)
		{
			$post['videofile1'] = $videofile1;
		}

		if(!\dash\engine\process::status())
		{
			return;
		}

		\lib\app\lottery_user::add($post);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok('ثبت ‌نام شما با موفقیت انجام شد.'. ' '. 'لطفا منتظر اعلام نتایج بمانید', ['alerty' => true]);

			$_SESSION['LOTTERY_NEW_SIGNUP'] = true;
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>
