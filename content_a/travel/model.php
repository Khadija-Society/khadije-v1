<?php
namespace content_a\travel;


class model extends \content_a\main\model
{

	public function post_travel()
	{
		var_dump(\lib\utility::post());exit();

		'city'      => string 'qom' (length=3)
		'place'     => string 'qom_1' (length=5)
		'startdate' => string '۱۳۹۶/۰۱/۲۸' (length=18)
		'enddate'   => string '۱۳۹۷/۰۲/۱۰' (length=18)
		'child_14'  => string 'on' (length=2)
		'child_15'  => string 'on' (length=2)
		'child_16'  => string 'on' (length=2)
		'child_17'  => string 'on' (length=2)

		if(\lib\utility::post('remove') === \lib\utility::get('edit') && \lib\utility::get('edit') != '')
		{
			\lib\app\myuser::remove_travel(\lib\utility::get('edit'));
			if(\lib\debug::$status)
			{
				$this->redirector($this->url('baseFull'). '/travel');
			}
		}
		else
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

			if(\lib\utility::get('edit') && \lib\utility::get('edit') != '')
			{

				\lib\app\myuser::edit_travel($post, \lib\utility::get('edit'));
			}
			else
			{
				\lib\app\myuser::add_travel($post);
			}

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Your Child was saved"));
				$this->redirector($this->url('full'));
			}

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
