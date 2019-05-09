<?php
namespace content_api\v6\smsapp;


class sent
{
	public static function set()
	{
		$smsid = \dash\request::post('smsid');
		$smsid = \dash\coding::decode($smsid);
		if(!$smsid)
		{
			\dash\notif::error(T_("Invalid sms id"));
			return false;
		}

		$load = \lib\db\sms::get(['s_sms.id' => $smsid, 'limit' => 1]);

		if(!isset($load['id']) || !isset($load['sendstatus']))
		{
			\dash\notif::error(T_("Sms id not found"));
			return false;
		}

		if($load['sendstatus'] === 'sendtodevice')
		{
			$gateway = \dash\header::get('gateway');
			$gateway = \dash\utility\filter::mobile($gateway);

			$get_args =
			[
				'cat'   => 'smsapp',
				'key'   => 'limit_'. date("Y-m-d"). '_'. $gateway,
				'limit' => 1,
			];

			$get_option = \dash\db\options::get($get_args);

			$value = 0;

			if(isset($get_option['value']))
			{
				$value = intval($value);
			}

			$sms_text = isset($load['answertext']) ? $load['answertext'] : null;

			if($sms_text)
			{
				$value += ceil(mb_strlen($sms_text) / 70);
			}
			else
			{
				$value++;
			}

			if(isset($get_option['id']))
			{
				\dash\db\options::update(['value' => $value], $get_option['id']);
			}
			else
			{
				unset($get_args['limit']);
				$get_args['value'] = $value;
				\dash\db\options::insert($get_args);
			}



			\lib\db\sms::update(['sendstatus' => 'send', 'datesend' => date("Y-m-d H:i:s")], $smsid);
			\dash\notif::ok(T_("The message set as sent message"));
			return true;
		}
		else
		{
			\dash\notif::error(T_("This message is not ready to save as sent message"));
			return false;
		}

	}
}
?>