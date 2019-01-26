<?php
namespace content_cp\trip\view;


class model
{
	public static function getPost()
	{
		\dash\permission::access('cpTripEdit');

		$post                    = [];
		$post['firstname']       = \dash\request::post('name');
		$post['lastname']        = \dash\request::post('lastName');
		$post['father']          = \dash\request::post('father');
		$post['nationalcode']    = \dash\request::post('nationalcode');
		$post['birthday']        = \dash\request::post('birthday');
		$post['gender']          = \dash\request::post('gender') ? 'female' : 'male';
		$post['married']         = \dash\request::post('Married') ? 'married' : 'single';
		$post['nesbat']          = \dash\request::post('nesbat');
		return $post;
	}


	public static function post()
	{
		if(\dash\request::post('type') === 'remove' && \dash\request::post('key') != '' && ctype_digit(\dash\request::post('key')))
		{
			\lib\db\travelusers::remove(\dash\request::post('key'), \dash\request::get('id'));
			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
		}
		elseif(\dash\request::post('save_child') === 'save_child')
		{
			$post = self::getPost();

			$post['travel_id']       = \dash\request::get('id');

			\lib\app\myuser::add_child($post);

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Your Child was saved"));
				\dash\redirect::to(\dash\url::here(). '/trip/view?id='. \dash\request::get('id'));
			}

		}
		elseif(\dash\request::post('edit_child') === 'edit_child' && \dash\request::get('partner') && is_numeric(\dash\request::get('partner')))
		{
			$post              = self::getPost();
			$post['travel_id'] = \dash\request::get('id');

			$get_user_id = \lib\db\travelusers::get(['id' => \dash\request::get('partner'), 'travel_id' => \dash\request::get('id'), 'limit' => 1]);

			if(isset($get_user_id['user_id']))
			{
				$user_id = $get_user_id['user_id'];
			}
			else
			{
				\dash\notif::error(T_("Invalid user travel detail"));
				return false;
			}

			\lib\app\myuser::edit_child($post, $user_id);

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("The partner was updated"));
				\dash\redirect::to(\dash\url::here(). '/trip/view?id='. \dash\request::get('id'));
			}
		}
		elseif(\dash\request::post('edit_travel') === 'edit_travel')
		{
			$start_date = \dash\request::post('startdate');
			$start_date = \dash\utility\convert::to_en_number($start_date);
			if($start_date && strtotime($start_date) === false)
			{
				\dash\notif::error(T_("Invalid start_date"), 'start_date');
				return false;
			}

			if(\dash\utility\jdate::is_jalali($start_date))
			{
				$start_date = \dash\utility\jdate::to_gregorian($start_date);
			}

			if($start_date)
			{
				$start_date = date("Y-m-d", strtotime($start_date));
			}
			else
			{
				$start_date = null;
			}

			$end_date   = \dash\request::post('enddate');
			$end_date   = \dash\utility\convert::to_en_number($end_date);
			if($end_date && strtotime($end_date) === false)
			{
				\dash\notif::error(T_("Invalid end_date"), 'end_date');
				return false;
			}

			if(\dash\utility\jdate::is_jalali($end_date))
			{
				$end_date = \dash\utility\jdate::to_gregorian($end_date);
			}

			if($end_date)
			{
				$end_date = date("Y-m-d", strtotime($end_date));
			}
			else
			{
				$end_date = null;
			}


			$desc       = \dash\request::post('desc');

			if(mb_strlen($desc) > 500)
			{
				\dash\notif::error(T_("Maximum input for desc"), 'desc');
				return false;
			}

			$status = \dash\request::post('status');

			if($status && !in_array($status, ['awaiting', 'spam', 'cancel', 'reject', 'review', 'notanswer', 'queue','gone', 'delete','admincancel', 'draft']))
			{
				\dash\notif::error(_T("Invalid status of trip"), 'status');
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

			\lib\db\travels::update($update, \dash\request::get('id'));

			self::send_sms($status);

			\dash\notif::ok(T_("The travel updated"));

			\dash\redirect::pwd();

		}

	}


	public static function send_sms($_status)
	{
		$mobile        = null;
		$msg           = '';
		$travelDetail = \lib\db\travels::get(['id' => \dash\request::get('id'), 'limit' => 1]);
		if(!isset($travelDetail['user_id']))
		{
			return;
		}

		$load_user = \dash\db\users::get_by_id($travelDetail['user_id']);
		if(!isset($load_user['mobile']))
		{
			return;
		}
		if(!\dash\utility\filter::mobile($load_user['mobile']))
		{
			return;
		}

		$mobile = $load_user['mobile'];

		if(isset($travelDetail['place']))
		{
			$city = T_($travelDetail['place']);
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
			\dash\utility\sms::send($mobile, $msg);
		}
	}

}
?>
