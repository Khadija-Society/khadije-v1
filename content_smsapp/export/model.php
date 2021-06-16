<?php
namespace content_smsapp\export;


class model
{
	public static function post()
	{

		$starttime      = \dash\date::make_time(\dash\request::post('starttime'));
		$startdate      = \dash\request::post('startdate');
		if(array_key_exists('startdate', $_POST))
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

		$endtime      = \dash\date::make_time(\dash\request::post('endtime'));
		$enddate        = \dash\request::post('enddate');
		if(array_key_exists('enddate', $_POST))
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

		$mobile = \dash\request::post('mobile');
		if($mobile)
		{
			$mobile = \dash\utility\filter::mobile($mobile);
			if(!$mobile)
			{
				$mobile = null;
			}
		}

		if(\dash\request::post('export'))
		{
			$data = \lib\db\sms::export_mobile($startdate, $enddate, \dash\request::post('q'), \dash\request::post('onlymobile'), $mobile, \lib\app\platoon\tools::get_index_locked());
			if($data === false)
			{
				return false;
			}

			$link = \dash\utility\export::csv_file(['name' => 'export_sms_'.$startdate. '_'. $enddate, 'data' => $data]);
			if($link)
			{
				\dash\redirect::to($link);
			}
		}



	}
}
?>
