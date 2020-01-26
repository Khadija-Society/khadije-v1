<?php
namespace content_agent\send\view;


class model
{
	public static function post()
	{
		if(\dash\request::post('alert') === 'alert')
		{
			$caller = 'servantAssessment';

			$user_id = [];
			$data = \dash\data::dataRow();

			if(isset($data['clergy_id']) && $data['clergy_id'])
			{
				$user_id[] = \dash\coding::decode($data['clergy_id']);
			}

			if(isset($data['admin_id']) && $data['admin_id'])
			{
				$user_id[] = \dash\coding::decode($data['admin_id']);
			}

			if(isset($data['adminoffice_id']) && $data['adminoffice_id'])
			{
				$user_id[] = \dash\coding::decode($data['adminoffice_id']);
			}

			if(isset($data['missionary_id']) && $data['missionary_id'])
			{
				$user_id[] = \dash\coding::decode($data['missionary_id']);
			}

			if(isset($data['servant_id']) && $data['servant_id'])
			{
				$user_id[] = \dash\coding::decode($data['servant_id']);
			}

			if(isset($data['servant2_id']) && $data['servant2_id'])
			{
				$user_id[] = \dash\coding::decode($data['servant2_id']);
			}

			if(isset($data['maddah_id']) && $data['maddah_id'])
			{
				$user_id[] = \dash\coding::decode($data['maddah_id']);
			}

			if(isset($data['rabet_id']) && $data['rabet_id'])
			{
				$user_id[] = \dash\coding::decode($data['rabet_id']);
			}

			if(isset($data['nazer_id']) && $data['nazer_id'])
			{
				$user_id[] = \dash\coding::decode($data['nazer_id']);
			}

			if(isset($data['khadem_id']) && $data['khadem_id'])
			{
				$user_id[] = \dash\coding::decode($data['khadem_id']);
			}

			if(isset($data['khadem2_id']) && $data['khadem2_id'])
			{
				$user_id[] = \dash\coding::decode($data['khadem2_id']);
			}

			$user_id = array_filter($user_id);
			$user_id = array_unique($user_id);
			if($user_id)
			{
				foreach ($user_id as $key => $value)
				{
					\dash\log::set($caller, ['to' => $value]);
				}
			}

			$id = \dash\request::get('id');
			$id = \dash\coding::decode($id);
			if($id)
			{
				\dash\notif::ok('اطلاع رسانی انجام شد');
				\lib\db\send::update(['alertassessment_count' => 1, 'alertassessment_date' => date("Y-m-d H:i:s")], $id);

			}
			\dash\redirect::pwd();

			return;
		}


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