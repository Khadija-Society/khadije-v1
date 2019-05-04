<?php
namespace content_m\representation\view;


class model
{

	public static function post()
	{
		\dash\permission::access('cpRepresentationChangeStatus');

		$status = \dash\request::post('status');

		if(!in_array($status, ['draft','awaiting','accept','reject','cancel','spam']))
		{
			\dash\notif::error(_T("Invalid status of trip"), 'status');
			return false;
		}

		$update = [];
		$update['status'] = $status;
		\dash\log::set('representationChangeStatus', ['code' => \dash\request::get('id'), 'mystatus' => $status]);
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
		$place = $detail['expert'];

		switch ($_status)
		{
			case 'accept':
				$msg = T_("Your representation request for :place is done.", ['place' => $place]);

				break;
		}

		if($msg && $mobile)
		{
			\dash\utility\sms::send($mobile, $msg);
		}
	}

}
?>
