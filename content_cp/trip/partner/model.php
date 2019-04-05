<?php
namespace content_cp\trip\partner;


class model
{
	public static function getPost()
	{
		\dash\permission::access('cpTripEdit');

		$post                 = [];
		$post['firstname']    = \dash\request::post('name');
		$post['lastname']     = \dash\request::post('lastName');
		$post['father']       = \dash\request::post('father');
		$post['mobile2']      = \dash\request::post('mobile');
		$post['nationalcode'] = \dash\request::post('nationalcode');
		$post['birthday']     = \dash\request::post('birthday');
		$post['gender']       = \dash\request::post('gender') ? 'female' : 'male';
		$post['married']      = \dash\request::post('Married') ? 'married' : 'single';
		$post['nesbat']       = \dash\request::post('nesbat');
		$post['type']         = \dash\request::post('type');
		return $post;
	}


	public static function post()
	{
		if(\dash\request::post('export') === 'export_partner')
		{

			\dash\utility\export::csv(['name' => 'export_trip_'. \dash\request::get('id'), 'data' => \dash\data::travelPartner()]);

			return;
		}

		if(\dash\request::post('type') === 'remove' && \dash\request::post('key') != '' && ctype_digit(\dash\request::post('key')))
		{
			\dash\log::set('removePartnerGroupTrip', ['code' => \dash\request::get('id')]);
			\lib\db\travelusers::remove(\dash\request::post('key'), \dash\request::get('id'));
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Partner successfully removed"));
				\dash\redirect::pwd();
			}
		}
		elseif(\dash\request::post('save_child') === 'save_child')
		{
			$post = self::getPost();
			$post['not_force_birthday'] = true;

			$post['travel_id']       = \dash\request::get('id');

			\lib\app\myuser::add_child($post);

			if(\dash\engine\process::status())
			{
				\dash\log::set('AddPartnerGroupTrip', ['code' => \dash\request::get('id')]);
				\dash\notif::ok(T_("Your Child was saved"));
				\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));
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
				\dash\log::set('editPartnerGroupTrip', ['code' => \dash\request::get('id')]);
				\dash\notif::ok(T_("The partner was updated"));
				\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));
			}
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
