<?php
namespace content_a\trip\profile;


class model extends \content_a\main\model
{

	public function post_profile()
	{
		$post                    = [];
		$post['gender']          = \lib\utility::post('gender') ? 'female' : 'male';
		$post['email']           = \lib\utility::post('email');
		$post['birthday']        = \lib\utility::post('birthday');
		$post['firstname']       = \lib\utility::post('name');
		$post['lastname']        = \lib\utility::post('lastName');
		$post['nationalcode']    = \lib\utility::post('nationalcode');
		$post['father']          = \lib\utility::post('father');
		$post['pasportcode']     = \lib\utility::post('passport');
		$post['pasportdate']     = \lib\utility::post('passportexpire');
		$post['education']       = \lib\utility::post('education');
		$post['educationcourse'] = \lib\utility::post('educationcourse');
		$post['country']         = \lib\utility::post('country');
		$post['province']        = \lib\utility::post('province');
		$post['city']            = \lib\utility::post('city');
		$post['homeaddress']     = \lib\utility::post('homeaddress');
		$post['workaddress']     = \lib\utility::post('workaddress');
		$post['arabiclang']      = \lib\utility::post('ArabicLang') ? 'yes' : 'no';
		$post['phone']           = \lib\utility::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \lib\utility::post('Married') ? 'married' : 'single';
		$post['zipcode']         = \lib\utility::post('zipcode');
		$post['desc']            = \lib\utility::post('desc');
		$post['job']             = \lib\utility::post('job');

		$upload_avatar = self::upload_avatar();
		if($upload_avatar === false)
		{
			return false;
		}

		if($upload_avatar)
		{
			$post['avatar'] = $upload_avatar;
		}

		\lib\app\myuser::edit($post);

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Your detail was saved"));
			$this->redirector($this->url('baseFull'). '/trip/partner?trip='. \lib\utility::get('trip'));
		}

	}


	/**
	 * Uploads a avatar.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function upload_avatar()
	{
		if(\lib\utility::files('avatar'))
		{
			$uploaded_file = \lib\app\file::upload(['debug' => false, 'upload_name' => 'avatar']);

			if(isset($uploaded_file['url']))
			{
				return $uploaded_file['url'];
			}
			// if in upload have error return
			if(!\lib\debug::$status)
			{
				return false;
			}
		}
		return null;
	}

}
?>
