<?php
namespace content_a\profile;


class model extends \content_a\main\model
{

	public function post_profile()
	{
		$post                    = [];
		$post['gender']          = \lib\request::post('gender') ;
		$post['email']           = \lib\request::post('email');
		$post['birthday']        = \lib\request::post('birthday');
		$post['firstname']       = \lib\request::post('name');
		$post['lastname']        = \lib\request::post('lastName');
		$post['nationalcode']    = \lib\request::post('nationalcode');
		$post['father']          = \lib\request::post('father');
		$post['pasportcode']     = \lib\request::post('passport');
		$post['pasportdate']     = \lib\request::post('passportexpire');
		$post['country']         = \lib\request::post('country');
		$post['province']        = \lib\request::post('province');
		$post['city']            = \lib\request::post('city');
		$post['homeaddress']     = \lib\request::post('homeaddress');
		$post['phone']           = \lib\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \lib\request::post('Married') ;
		$post['zipcode']         = \lib\request::post('zipcode');

		\lib\app\myuser::edit($post);

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Your detail was saved"));
			\lib\redirect::to(\lib\url::here());
		}

	}
}
?>
