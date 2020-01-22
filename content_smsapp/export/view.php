<?php
namespace content_smsapp\export;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('file-o');

		\dash\data::page_title("خروجی از پیامک‌ها");

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Dashboard'));


		$starttime      = \dash\date::make_time(\dash\request::get('starttime'));
		$startdate      = \dash\request::get('startdate');
		if(array_key_exists('startdate', $_GET))
		{
			$startdate = $startdate . ' '. $starttime;
			$startdate                 = \dash\utility\convert::to_en_number($startdate);
			if(\dash\utility\jdate::is_jalali($startdate))
			{
				$startdate = \dash\utility\jdate::to_gregorian($startdate);
			}

			if(!$startdate)
			{
				\dash\notif::error(T_("Start date is required"), 'startdate');
				return false;
			}
			$startdate = $startdate . ' '. $starttime;

		}

		$endtime      = \dash\date::make_time(\dash\request::get('endtime'));
		$enddate        = \dash\request::get('enddate');
		if(array_key_exists('enddate', $_GET))
		{
			$enddate = $enddate . ' '. $endtime;
			$enddate                 = \dash\utility\convert::to_en_number($enddate);
			if(\dash\utility\jdate::is_jalali($enddate))
			{
				$enddate = \dash\utility\jdate::to_gregorian($enddate);
			}

			if(!$enddate)
			{
				\dash\notif::error(T_("End date is required"), 'enddate');
				return false;
			}

			$enddate = $enddate . ' '. $endtime;

			if($startdate && $enddate)
			{
				if(intval(strtotime($startdate)) > intval(strtotime($enddate)))
				{
					\dash\notif::error(T_("Start date must before end date"), ['element' => ['startdate', 'enddate', 'starttime', 'endtime']]);
					return false;
				}
			}

		}

		$startdate = trim($startdate);
		$enddate   = trim($enddate);

		if(\dash\request::get('export'))
		{
			$data = \lib\db\sms::export_mobile($startdate, $enddate);

			\dash\utility\export::csv(['name' => 'export_sms_'.$startdate. '_'. $enddate, 'data' => $data]);
		}

	}
}
?>
