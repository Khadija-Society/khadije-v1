<?php
namespace content_cp\trip\view;


class model extends \content_cp\main2\model
{
	public static function getPost()
	{
		$post                    = [];
		$post['firstname']       = \lib\utility::post('name');
		$post['lastname']        = \lib\utility::post('lastName');
		$post['father']          = \lib\utility::post('father');
		$post['nationalcode']    = \lib\utility::post('nationalcode');
		$post['birthday']        = \lib\utility::post('birthday');
		$post['gender']          = \lib\utility::post('gender') ? 'female' : 'male';
		$post['married']         = \lib\utility::post('Married') ? 'married' : 'single';
		$post['nesbat']          = \lib\utility::post('nesbat');
		return $post;
	}

	public function post_trip()
	{
		if(\lib\utility::post('type') === 'remove' && \lib\utility::post('key') != '' && ctype_digit(\lib\utility::post('key')))
		{
			\lib\db\travelusers::remove(\lib\utility::post('key'), \lib\utility::get('id'));
			if(\lib\debug::$status)
			{
				$this->redirector($this->url('full'));
			}
		}
		elseif(\lib\utility::post('save_child') === 'save_child')
		{
			$post = self::getPost();

			$post['travel_id']       = \lib\utility::get('id');

			\lib\app\myuser::add_child($post);

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Your Child was saved"));
				$this->redirector($this->url('baseFull'). '/trip/view?id='. \lib\utility::get('id'));
			}

		}
		elseif(\lib\utility::post('edit_child') === 'edit_child' && \lib\utility::get('partner') && is_numeric(\lib\utility::get('partner')))
		{
			$post              = self::getPost();
			$post['travel_id'] = \lib\utility::get('id');
			$get_user_id = \lib\db\travelusers::get(['id' => \lib\utility::get('partner'), 'travel_id' => \lib\utility::get('id'), 'limit' => 1]);
			if(isset($get_user_id['user_id']))
			{
				$user_id = $get_user_id['user_id'];
			}
			else
			{
				\lib\debug::error(T_("Invalid user travel detail"));
				return false;
			}
			\lib\app\myuser::edit_child($post, $user_id);

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("The partner was updated"));
				$this->redirector($this->url('baseFull'). '/trip/view?id='. \lib\utility::get('id'));
			}
		}

	}
}
?>
