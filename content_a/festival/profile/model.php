<?php
namespace content_a\festival\profile;


class model
{

	public static function post()
	{
		$post                    = [];
		$post['gender']          = \dash\request::post('gender') ;
		$post['email']           = \dash\request::post('email');
		$post['birthday']        = \dash\request::post('birthday');
		$post['firstname']       = \dash\request::post('name');
		$post['lastname']        = \dash\request::post('lastName');
		$post['nationalcode']    = \dash\request::post('nationalcode');
		$post['father']          = \dash\request::post('father');
		$post['pasportcode']     = \dash\request::post('passport');
		$post['pasportdate']     = \dash\request::post('passportexpire');
		$post['country']         = \dash\request::post('country');
		$post['province']        = \dash\request::post('province');
		$post['city']            = \dash\request::post('city');
		$post['homeaddress']     = \dash\request::post('homeaddress');
		$post['phone']           = \dash\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \dash\request::post('Married') ;
		$post['zipcode']         = \dash\request::post('zipcode');


		$post['festivals_universityname'] = \dash\request::post('festivals_universityname');
		$post['festivals_universitytype'] = \dash\request::post('festivals_universitytype');
		$post['festivals_universitynumber'] = \dash\request::post('festivals_universitynumber');

		\lib\app\myuser::edit($post);

		if(\dash\engine\process::status())
		{
			\dash\data::userdetail(\dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]));

			$complete_profile = \dash\data::userdetail_iscompleteprofile();
			if(intval($complete_profile) === 0)
			{
				\dash\notif::error(T_("Please complete your profile to go next"), ['element' => ['gender','birthday','name','lastName','father']]);
			}
			else
			{
				\dash\notif::ok(T_("Your detail was saved"));
				\dash\redirect::to(\dash\url::here(). '/festival/request?'. http_build_query(\dash\request::get()));
			}

		}

	}
}
?>
