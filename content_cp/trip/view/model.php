<?php
namespace content_cp\trip\view;


class model extends \content_cp\main2\model
{
	public static function getPost()
	{
		$post                    = [];
		$post['firstname']       = \lib\request::post('name');
		$post['lastname']        = \lib\request::post('lastName');
		$post['father']          = \lib\request::post('father');
		$post['nationalcode']    = \lib\request::post('nationalcode');
		$post['birthday']        = \lib\request::post('birthday');
		$post['gender']          = \lib\request::post('gender') ? 'female' : 'male';
		$post['married']         = \lib\request::post('Married') ? 'married' : 'single';
		$post['nesbat']          = \lib\request::post('nesbat');
		return $post;
	}


	public function post_trip()
	{
		if(\lib\request::post('type') === 'remove' && \lib\request::post('key') != '' && ctype_digit(\lib\request::post('key')))
		{
			\lib\db\travelusers::remove(\lib\request::post('key'), \lib\utility::get('id'));
			if(\lib\debug::$status)
			{
				$this->redirector(\lib\url::pwd());
			}
		}
		elseif(\lib\request::post('save_child') === 'save_child')
		{
			$post = self::getPost();

			$post['travel_id']       = \lib\utility::get('id');

			\lib\app\myuser::add_child($post);

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Your Child was saved"));
				$this->redirector(\lib\url::here(). '/trip/view?id='. \lib\utility::get('id'));
			}

		}
		elseif(\lib\request::post('edit_child') === 'edit_child' && \lib\utility::get('partner') && is_numeric(\lib\utility::get('partner')))
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
				$this->redirector(\lib\url::here(). '/trip/view?id='. \lib\utility::get('id'));
			}
		}
		elseif(\lib\request::post('edit_travel') === 'edit_travel')
		{
			$start_date = \lib\request::post('startdate');
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

			$end_date   = \lib\request::post('enddate');
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


			$desc       = \lib\request::post('desc');

			if(mb_strlen($desc) > 500)
			{
				\lib\debug::error(T_("Maximum input for desc"), 'desc');
				return false;
			}

			$status = \lib\request::post('status');

			if($status && !in_array($status, ['awaiting', 'spam', 'cancel', 'reject', 'review', 'notanswer', 'queue','gone', 'delete','admincancel', 'draft']))
			{
				\lib\debug::error(_T("Invalid status of trip"), 'status');
				return false;
			}

			$update              = [];
			$update['startdate'] = $start_date;
			$update['enddate']   = $end_date;
			$update['desc']      = $desc;

			if($status)
			{
				$update['status'] = $status;
			}

			\lib\db\travels::update($update, \lib\utility::get('id'));

			$this->send_sms($status);

			\lib\debug::true(T_("The travel updated"));

			$this->redirector(\lib\url::pwd());

		}

	}


	public function send_sms($_status)
	{
		$mobile        = null;
		$msg           = '';
		$travel_detail = \lib\db\travels::get(['id' => \lib\utility::get('id'), 'limit' => 1]);
		if(!isset($travel_detail['user_id']))
		{
			return;
		}

		$load_user = \lib\db\users::get_by_id($travel_detail['user_id']);
		if(!isset($load_user['mobile']))
		{
			return;
		}
		if(!\lib\utility\filter::mobile($load_user['mobile']))
		{
			return;
		}

		$mobile = $load_user['mobile'];

		if(isset($travel_detail['place']))
		{
			$city = T_($travel_detail['place']);
		}

		switch ($_status)
		{
			case 'awaiting':
				$msg = "درخواست تشرف به $city در حال انتظمار است.";
				break;

			case 'review':
				$msg = "درخواست تشرف به $city در دست بررسی است. بزودی با شما تماس خواهیم گرفت.";
				break;

			case 'queue':
				$msg = "درخواست تشرف به $city در تایید شده و شما در صف تشرف قرار گرفته‌اید.";
				break;

			case 'notanswer':
				$msg = "برای درخواست تشرف به $city با شما تماس گرفته شد و پاسخگو نبودید.";
				break;


			case 'spam':
			case 'draft':
			case 'cancel':
			case 'gone':
			case 'reject':
			case 'admincancel':

				break;

			default:
				break;
		}

		if($msg && $mobile)
		{
			\lib\utility\sms::send($mobile, $msg);
		}
	}

}
?>
