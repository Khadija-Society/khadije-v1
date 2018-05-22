<?php
namespace content_cp\representation\view;


class model
{

	public static function post()
	{
		$status = \dash\request::post('status');

		if(!in_array($status, ['draft','awaiting','accept','reject','cancel','spam']))
		{
			\dash\notif::error(_T("Invalid status of trip"), 'status');
			return false;
		}

		$update = [];
		$update['status'] = $status;

		\lib\db\services::update($update, \dash\request::get('id'));

		self::send_sms($status);

		\dash\notif::ok(T_("The representation updated"));

		\dash\redirect::pwd();

	}


	public static function send_sms($_status)
	{
		$mobile        = null;
		$msg           = '';
		$detail = \dash\data::representationDetail();

		if(!isset($detail['mobile']))
		{
			return;
		}

		$mobile = $detail['mobile'];

		switch ($_status)
		{
			case 'accept':
				$msg = "زیارت نیابتی از طرف شما انجام شد";
				break;
		}

		if($msg && $mobile)
		{
			\dash\utility\sms::send($mobile, $msg);
		}
	}

}
?>
