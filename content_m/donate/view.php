<?php
namespace content_m\donate;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDonateView');


		\dash\data::page_pictogram('card');

		\dash\data::page_title(T_("Donation list"));
		\dash\data::page_desc(T_("check last donates and monitor all donate transaction"));

		\dash\data::badge_link(\dash\url::here(). '/donate/options');
		\dash\data::badge_text(T_('Options'));

		$exportLinkArgs = \dash\request::get();
		$exportLinkArgs['export'] = 'true';

		\dash\data::badge2_link(\dash\url::here(). '/donate?'. http_build_query($exportLinkArgs));
		\dash\data::badge2_text(T_("Export"));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		$payment_args = [];
		$filterArgs   = [];
		$args =
		[
			'order'          => \dash\request::get('order'),
			'sort'           => \dash\request::get('sort'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(!$args['sort'])
		{
			$args['sort'] = 'dateverify';
		}

		if(\dash\request::get('payment'))
		{
			$args['payment'] = \dash\request::get('payment');
			$payment_args['payment'] = \dash\request::get('payment');
		}


		if(\dash\request::get('paygateway'))
		{
			$args['paygateway'] = \dash\request::get('paygateway');
			$payment_args['paygateway'] = \dash\request::get('paygateway');
		}

		if(\dash\request::get('id'))
		{
			$args['transactions.id'] = \dash\coding::decode(\dash\request::get('id'));
			$payment_args['transactions.id'] = \dash\request::get('id');
		}

		if(\dash\request::get('mobile'))
		{
			$args['mobile'] = \dash\request::get('mobile');
			$userDetail = \dash\db\users::get_by_mobile($args['mobile']);
			if(isset($userDetail['id']))
			{
				$payment_args['user_id'] = $userDetail['id'];
			}
		}

		if(\dash\request::get('hazinekard'))
		{
			$args['hazinekard'] = \dash\request::get('hazinekard');
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
			\dash\data::enddateEn($enddate);

		}


		if($startdate && $enddate)
		{
			$args['1.1'] = [" = 1.1 ", " AND DATE(transactions.datecreated) >= '$startdate' AND DATE(transactions.datecreated) <= '$enddate'  "];
			$payment_args['1.1'] = [" = 1.1 ", " AND DATE(transactions.datecreated) >= '$startdate' AND DATE(transactions.datecreated) <= '$enddate'  "];

		}
		elseif($startdate)
		{
			$args['DATE(transactions.datecreated)'] = [">=", " '$startdate' "];
			$payment_args['DATE(transactions.datecreated)'] = [">=", " '$startdate' "];
		}
		elseif($enddate)
		{
			$args['DATE(transactions.datecreated)'] = ["<=", " '$enddate' "];
			$payment_args['DATE(transactions.datecreated)'] = ["<=", " '$enddate' "];
		}

		if($get_date_url)
		{
			\dash\data::getDateURL('&'. http_build_query($get_date_url));

		}

		$new_query = false;

		if(\dash\request::get('filter') === 'maxpay')
		{
			$new_query = true;
			$args['maxpay'] = true;
		}

		if(\dash\request::get('filter') === 'usercountpay')
		{
			$new_query = true;
			$args['usercountpay'] = true;
		}

		if(\dash\request::get('filter') === 'remembernotif')
		{
			$args['1.5'] = ["= 1.5 AND", " transactions.rememberdate IS NOT NULL"];
			$filterArgs['Remmeber notif'] = true;
		}

		$args['donate']            = 'cash';
		$payment_args['donate']    = 'cash';

		if(\dash\permission::supervisor() && \dash\request::get('condition'))
		{
			$args['condition']         = \dash\request::get('condition');
			$payment_args['condition'] = \dash\request::get('condition');

			$args['condition']         = ['!=' , " 'ok' "];
			$payment_args['condition'] = ['!=' , " 'ok' "];
		}
		else
		{
			$args['condition']         = 'ok';
			$payment_args['condition'] = 'ok';
		}

		$search_string     = \dash\request::get('q');

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}

		$export = false;
		if(\dash\request::get('export') === 'true')
		{
			$export = true;
			$args['pagenation'] = false;
		}

		if($export)
		{

			$dataTable = \lib\app\donate::export($search_string, $args);
			\dash\utility\export::csv(['name' => 'export_donate', 'data' => $dataTable]);
		}
		else
		{

			if($new_query)
			{
				if(isset($args['maxpay']))
				{
					$dataTable = \lib\db\transactions::list($search_string, $args);
				}
				else
				{
					$dataTable = \lib\db\transactions::list($search_string, $args);
				}
			}
			else
			{
				$dataTable = \dash\app\transaction::list($search_string, $args);
			}

			\dash\data::dataTable($dataTable);

		}



		\dash\data::sortLink(\content_m\view::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::here(). '/donate'));

		if(\dash\permission::check('cpDonateTotalPay'))
		{
			// \dash\data::totalPaid(\dash\app\transaction::total_paid($payment_args));
			// \dash\data::totalPaidDate(\dash\app\transaction::total_paid_date(date("Y-m-d"), $payment_args));
			// \dash\data::totalPaidCount(\dash\app\transaction::total_paid_count($payment_args));
		}

		$filterArray = $args;
		unset($filterArray['donate']);
		unset($filterArray['condition']);
		unset($filterArray['1.5']);

		$filterArray = array_merge($filterArgs, $filterArray);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
