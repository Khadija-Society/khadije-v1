<?php
namespace content_m\productdonate\home;


class view
{
	public static function config()
	{
		\dash\permission::access('mProductView');

		\dash\data::page_title(T_("products donate list"));

		\dash\data::page_pictogram('basket');

		\dash\data::badge_text(T_("Back"));
		\dash\data::badge_link(\dash\url::here());
		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$filterArgs   = [];
		$summary_args = [];

		$args =
		[
			'sort'  => \dash\request::get('sort'),
			'order' => \dash\request::get('order'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}


		if(\dash\request::get('transaction'))
		{
			$args['transaction_id'] = \dash\coding::decode(\dash\request::get('transaction'));

			$filterArgs['transaction'] = \dash\request::get('transaction');
		}

		if(\dash\request::get('product'))
		{
			$args['product_id']         = \dash\coding::decode(\dash\request::get('product'));
			$summary_args['product_id'] = $args['product_id'];
			$filterArgs['product']      = \dash\request::get('product');
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
			$args['1.1'] = [" = 1.1 ", " AND DATE(productdonate.datecreated) >= '$startdate' AND DATE(productdonate.datecreated) <= '$enddate'  "];
			$summary_args['1.1'] = [" = 1.1 ", " AND DATE(productdonate.datecreated) >= '$startdate' AND DATE(productdonate.datecreated) <= '$enddate'  "];
			$filterArgs['date'] = T_("Special");

		}
		elseif($startdate)
		{
			$args['DATE(productdonate.datecreated)'] = [">=", " '$startdate' "];
			$summary_args['DATE(productdonate.datecreated)'] = [">=", " '$startdate' "];
			$filterArgs['date'] = T_("Special");
		}
		elseif($enddate)
		{
			$args['DATE(productdonate.datecreated)'] = ["<=", " '$enddate' "];
			$summary_args['DATE(productdonate.datecreated)'] = ["<=", " '$enddate' "];
			$filterArgs['date'] = T_("Special");
		}


		$allProduct = \lib\app\product::all_list();
		\dash\data::productList($allProduct);


		$summary = \lib\app\productdonate::summary($summary_args);
		\dash\data::productdonateSummary($summary);

		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\productdonate::$sort_field, \dash\url::this());
		$dataTable = \lib\app\productdonate::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);


		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);


	}
}
?>