<?php
namespace lib\app\log\caller;



class tankyouMessage
{

	public static function site($_args = [])
	{
		$message = \lib\app\message::get();

		if(isset($message['text']) && $message['text'])
		{
			$result              = [];
			$result['title']     = T_("Thank you");
			$result['icon']      = 'heart';
			$result['cat']       = T_("Donate");
			$result['iconClass'] = 'fc-green';
			$result['txt']       = $message['text'];
			return $result;
		}
		else
		{
			return false;
		}
	}

	public static function expire()
	{
		return date("Y-m-d H:i:s", strtotime("+365 days"));
	}


	public static function is_notif()
	{
		$message = \lib\app\message::get();

		if(isset($message['active']) && $message['active'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public static function telegram()
	{
		return true;
	}


	public static function sms()
	{
		$message = \lib\app\message::get();
		if(isset($message['sms']) && $message['sms'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public static function sms_text($_args, $_mobile)
	{
		$message = \lib\app\message::get();

		if(isset($message['text']) && $message['text'])
		{
			$result['txt'] = $message['text'];
			$sms =
			[
				'mobile' => $_mobile,
				'text'   => $message['text'],
				'meta'   =>
				[
					'footer' => false
				]
			];
			return json_encode($sms, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			return false;
		}
	}


	public static function telegram_text($_args, $_chat_id)
	{
		$message = \lib\app\message::get();
		if(isset($message['text']) && $message['text'])
		{
			$tg                 = [];
			$tg['chat_id']      = $_chat_id;
			$tg['text']         = $message['text'];
			$tg['reply_markup'] = \dash\app\log\support_tools::tg_btn2($code);
			// $tg = json_encode($tg, JSON_UNESCAPED_UNICODE);
			return $tg;
		}
		else
		{
			return false;
		}
	}
}
?>