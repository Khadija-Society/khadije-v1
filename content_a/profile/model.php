<?php
namespace content_a\profile;


class model extends \content_a\main\model
{

	public function post_profile()
	{
		$post                    = [];
		$post['gender']          = \lib\utility::post('gender') ;
		$post['email']           = \lib\utility::post('email');
		$post['birthday']        = \lib\utility::post('birthday');
		$post['firstname']       = \lib\utility::post('name');
		$post['lastname']        = \lib\utility::post('lastName');
		$post['nationalcode']    = \lib\utility::post('nationalcode');
		$post['father']          = \lib\utility::post('father');
		$post['pasportcode']     = \lib\utility::post('passport');
		$post['pasportdate']     = \lib\utility::post('passportexpire');
		$post['country']         = \lib\utility::post('country');
		$post['province']        = \lib\utility::post('province');
		$post['city']            = \lib\utility::post('city');
		$post['homeaddress']     = \lib\utility::post('homeaddress');
		$post['phone']           = \lib\utility::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \lib\utility::post('Married') ;
		$post['zipcode']         = \lib\utility::post('zipcode');

		\lib\app\myuser::edit($post);

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Your detail was saved"));
			$this->redirector(\lib\url::here());
		}

	}
}
?>
