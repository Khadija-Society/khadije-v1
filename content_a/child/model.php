<?php
namespace content_a\child;


class model extends \content_a\main\model
{

	public function post_child()
	{
		$post                    = [];
		$post['firstname']       = \lib\utility::post('name');
		$post['lastname']        = \lib\utility::post('lastName');
		$post['father']          = \lib\utility::post('father');
		$post['nationalcode']    = \lib\utility::post('nationalcode');
		$post['birthday']        = \lib\utility::post('birthday');
		$post['job']             = \lib\utility::post('job');
		$post['gender']          = \lib\utility::post('gender') ? 'female' : 'male';
		$post['married']         = \lib\utility::post('Married') ? 'married' : 'single';
		$post['nesbat']          = \lib\utility::post('nesbat');


		$upload_avatar = self::upload_avatar();
		if($upload_avatar === false)
		{
			return false;
		}

		if($upload_avatar)
		{
			$post['avatar'] = $upload_avatar;
		}

		\lib\app\myuser::add_child($post);

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Your Child was saved"));
			$this->redirector($this->url('full'));
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
