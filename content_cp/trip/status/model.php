<?php
namespace content_cp\trip\status;


class model
{



	public static function post()
	{

		$status = \dash\request::post('status');

		if($status && !in_array($status, ['awaiting', 'spam', 'cancel', 'reject', 'review', 'notanswer', 'queue','gone', 'delete','admincancel', 'draft']))
		{
			\dash\notif::error(_T("Invalid status of trip"), 'status');
			return false;
		}

		$update              = [];

		if($status)
		{
			$update['status'] = $status;
		}

		\lib\db\travels::update($update, \dash\request::get('id'));

		\dash\log::set('updatePartnerGroupTrip', ['code' => \dash\request::get('id'), 'update' => $update]);

		self::send_sms($status);

		if($status === 'gone')
		{
			\lib\app\travel::trip_gone_to_place(\dash\request::get('id'));
		}

		\dash\notif::ok(T_("The travel updated"));

		\dash\redirect::pwd();



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
