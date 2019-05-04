<?php
namespace content_m\trip\profile;


class model
{

	public static function post()
	{
		if(\dash\request::post("RemoveNationalThumb"))
		{
			\dash\db\users::update(['file1' => null], \dash\user::id());
			\dash\notif::ok(T_("Picture removed"));
			\dash\redirect::pwd();
		}

		$post                       = [];
		$post['gender']             = \dash\request::post('gender') ;
		$post['email']              = \dash\request::post('email');
		$post['birthday']           = \dash\request::post('birthday');
		$post['not_force_birthday'] = true;
		$post['firstname']          = \dash\request::post('name');
		$post['lastname']           = \dash\request::post('lastName');
		$post['nationalcode']       = \dash\request::post('nationalcode');
		$post['father']             = \dash\request::post('father');
		$post['pasportcode']        = \dash\request::post('passport');
		$post['pasportdate']        = \dash\request::post('passportexpire');
		$post['country']            = \dash\request::post('country');
		$post['province']           = \dash\request::post('province');
		$post['city']               = \dash\request::post('city');
		$post['homeaddress']        = \dash\request::post('homeaddress');
		$post['phone']              = \dash\request::post('phone');
		$post['displayname']        = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']            = \dash\request::post('Married') ;
		$post['zipcode']            = \dash\request::post('zipcode');

		$file1 = \dash\app\file::upload_quick('file1');
		if($file1)
		{
			$post['file1'] = $file1;
		}

		\lib\app\myuser::edit($post, ['user_id' => \dash\coding::decode(\dash\request::get('user'))]);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your detail was saved"));
			\dash\redirect::to(\dash\url::here(). '/trip/view?id='. \dash\request::get('id'));
		}

	}
}
?>
