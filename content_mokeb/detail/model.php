<?php
namespace content_mokeb\detail;


class model
{

	public static function post()
	{


		$post                    = [];
		$post['mobile']          = \dash\request::post('mobile') ;
		$post['gender']          = \dash\request::post('gender') ;
		// $post['email']           = \dash\request::post('email');
		// $post['job']             = \dash\request::post('student') ? 'collegian' : null;
		// $post['birthday']        = \dash\request::post('birthday');
		$post['firstname']       = \dash\request::post('name');
		$post['lastname']        = \dash\request::post('lastName');
		$post['nationalcode']    = \dash\request::get('nationalcode');
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

		$id = \dash\data::mokebuserDetail_id();
		$id = \dash\coding::encode($id);
		\lib\app\mokebuser::edit($post, $id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok('اطلاعات با موفقیت ویرایش شد', ['alerty' => true]);


			\dash\redirect::pwd();
		}

	}
}
?>
