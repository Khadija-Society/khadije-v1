<?php
namespace content_agent\send\view;


class model
{
	public static function post()
	{

		if(\dash\request::post('xtime'))
		{
			$xtime = \dash\request::post('xtime');
			$xtime = \dash\date::make_time($xtime);

			if(!$xtime)
			{
				\dash\notif::error("لطفا ساعت را به صورت صحیح وارد کنید", 'xtime');
				return false;
			}

			$min = substr($xtime, 3, 2);
			if($min == '00')
			{
				$myTime = substr($xtime, 0, 2);
			}
			else
			{
				$myTime = substr($xtime, 0, 5);
			}

			$myTime = \dash\utility\human::fitNumber($myTime);
			\content_agent\send\billing\view::tempText($myTime);
			$text = \dash\data::smsText();

			$mobile = \dash\data::dataRow_missionary_mobile();

			if(!$mobile)
			{
				\dash\notif::error("مبلغ یافت نشد");
				return false;
			}

			$id = \dash\request::get('id');
			$id = \dash\coding::decode($id);
			if($id)
			{
				\dash\notif::ok('پیامک یادآوری ارسال شد');
				\lib\db\send::update(['alertsms' => $text, 'alertsmsdate' => date("Y-m-d H:i:s")], $id);
				\dash\utility\sms::send($mobile, $text);
			}
			\dash\redirect::pwd();

		}
	}
}
?>