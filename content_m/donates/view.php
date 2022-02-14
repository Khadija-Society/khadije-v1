<?php
namespace content_m\donates;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDonateViewFake');


		\dash\data::page_pictogram('card');

		\dash\data::page_title(T_("Donation list"));
		\dash\data::page_desc(T_("check last donates and monitor all donate transaction"));



		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);



		$payment_args = [];

		if(\dash\request::get('payment'))
		{
			$payment_args['payment'] = \dash\request::get('payment');
		}

		if(\dash\request::get('paygateway'))
		{
			$payment_args['paygateway'] = \dash\request::get('paygateway');
		}

		if(\dash\request::get('id'))
		{
			$payment_args['transactions.id'] = \dash\request::get('id');
		}

		if(\dash\request::get('hazinekard'))
		{
			$payment_args['hazinekard'] = \dash\request::get('hazinekard');
		}

		$startdate = null;
		$enddate   = null;

		$get_date_url = [];
		if(\dash\request::get('startdate'))
		{
			$startdate                 = \dash\request::get('startdate');
			$get_date_url['startdate'] = $startdate;
			$startdate                 = \dash\utility\convert::to_en_number($startdate);

			if(\dash\utility\jdate::is_jalali($startdate))
			{
				$startdate = \dash\utility\jdate::to_gregorian($startdate);
			}


			$starttime = \dash\date::make_time(\dash\request::get('starttime'));
			if(!$starttime)
			{
				$starttime = '00:00:00';
			}

			$startdate = $startdate . ' '. $starttime;

			\dash\data::startdateEn($startdate);



		}

		if(\dash\request::get('enddate'))
		{
			$enddate                 = \dash\request::get('enddate');
			$get_date_url['enddate'] = $enddate;
			$enddate                 = \dash\utility\convert::to_en_number($enddate);
			if(\dash\utility\jdate::is_jalali($enddate))
			{
				$enddate = \dash\utility\jdate::to_gregorian($enddate);
			}

			$endtime = \dash\date::make_time(\dash\request::get('endtime'));

			if(!$endtime)
			{
				$endtime = '23:59:59';
			}

			$enddate = $enddate . ' '. $endtime;


			\dash\data::enddateEn($enddate);

		}

		if(!$startdate && !$enddate)
		{
			if(\dash\permission::supervisor() && \dash\request::get('real'))
			{

			}
			else
			{
				$startdate = date("Y-m-d", strtotime('-1 year'));
			}
		}



		if($startdate && $enddate)
		{
			$payment_args['1.1'] = [" = 1.1 ", " AND transactions.datecreated >= '$startdate' AND transactions.datecreated <= '$enddate'  "];
		}
		elseif($startdate)
		{
			$payment_args['transactions.datecreated'] = [">=", " '$startdate' "];
		}
		elseif($enddate)
		{
			$payment_args['transactions.datecreated'] = ["<=", " '$enddate' "];
		}


		$payment_args['donate']    = 'cash';
		$payment_args['condition'] = 'ok';


		$result = \lib\app\donate::get_fake_report($payment_args);

		\dash\data::reportDetail($result);

	}
}
?>
