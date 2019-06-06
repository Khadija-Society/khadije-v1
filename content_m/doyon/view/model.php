<?php
namespace content_m\doyon\view;


class model
{

	public static function post()
	{


		$donestatus = \dash\request::post('donestatus');

		if(!in_array($donestatus, ['awaiting','ok','cancel']))
		{
			\dash\notif::error(T_("Invalid donestatus of trip"), 'donestatus');
			return false;
		}

		$desc                 = \dash\request::post('desc');
		$update               = [];
		$update['donestatus'] = $donestatus;
		$update['desc']       = $desc;
		\dash\log::set('updatedonate', ['code' => \dash\request::get('id'), 'newdonestatus' => $donestatus, 'newdesc' => $desc]);
		\lib\db\doyon::update($update, \dash\request::get('id'));

		// self::send_sms($status);

		\dash\notif::ok(T_("Doyon updated"));

		\dash\redirect::pwd();

	}


	public static function send_sms($_status)
	{
		$mobile        = null;
		$msg           = '';
		$detail = \dash\data::serviceDetail();

		if(!isset($detail['mobile']))
		{
			return;
		}

		$mobile = $detail['mobile'];
		$place = $detail['expert'];

		switch ($_status)
		{
			case 'accept':
				$msg = T_("Your service request for :place is done.", ['place' => $place]);

				break;
		}

		if($msg && $mobile)
		{
			\dash\utility\sms::send($mobile, $msg);
		}
	}

}
?>
