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
		elseif(\lib\utility::post('edit_travel') === 'edit_travel')
		{
			$start_date = \lib\utility::post('startdate');
			$start_date = \lib\utility\convert::to_en_number($start_date);
			if($start_date && strtotime($start_date) === false)
			{
				\lib\debug::error(T_("Invalid start_date"), 'start_date');
				return false;
			}

			if($start_date)
			{
				$start_date = date("Y-m-d", strtotime($start_date));
			}
			else
			{
				$start_date = null;
			}

			$end_date   = \lib\utility::post('enddate');
			$end_date   = \lib\utility\convert::to_en_number($end_date);
			if($end_date && strtotime($end_date) === false)
			{
				\lib\debug::error(T_("Invalid end_date"), 'end_date');
				return false;
			}

			if($end_date)
			{
				$end_date = date("Y-m-d", strtotime($end_date));
			}
			else
			{
				$end_date = null;
			}


			$desc       = \lib\utility::post('desc');

			if(mb_strlen($desc) > 500)
			{
				\lib\debug::error(T_("Maximum input for desc"), 'desc');
				return false;
			}

			$update =
			[
				'startdate' => $start_date,
				'enddate'   => $end_date,
				'desc'      => $desc,
			];
			\lib\db\travels::update($update, \lib\utility::get('id'));

			\lib\debug::true(T_("The travel updated"));

			$this->redirector($this->url('full'));

		}

	}
}
?>
