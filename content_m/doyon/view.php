<?php
namespace content_m\doyon;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDoyonView');

		\dash\data::page_pictogram('lock');

		\dash\data::page_title(T_("Doyon list"));

		\dash\data::badge_link(\dash\url::this(). '/report');
		\dash\data::badge_text(T_("Report"));


		\dash\data::badge2_link(\dash\url::this(). '?export=true');
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

		if(\dash\request::get('mobile'))
		{
			$args['mobile'] = \dash\request::get('mobile');
			$userDetail = \dash\db\users::get_by_mobile($args['mobile']);
			if(isset($userDetail['id']))
			{
				$payment_args['user_id'] = $userDetail['id'];
			}
		}


		$args['doyon.status'] = 'pay';


		if(\dash\request::get('title'))
		{
			$args['doyon.title'] = \dash\request::get('title');
			$filterArgs['title'] = \dash\request::get('title');
		}

		if(\dash\request::get('type'))
		{
			$args['doyon.type'] = \dash\request::get('type');
			$filterArgs['type'] = \dash\request::get('type');
		}

		if(\dash\request::get('count'))
		{
			$args['doyon.count'] = \dash\request::get('count');
			$filterArgs['count'] = \dash\request::get('count');
		}

		if(array_key_exists('seyyed', $_GET))
		{
			if(\dash\request::get('seyyed'))
			{
				$args['doyon.seyyed'] = 1;
				$filterArgs['seyyed'] = T_("Yes");
			}
			else
			{
				$args['doyon.seyyed'] = null;
				$filterArgs['seyyed'] = T_("No");
			}
		}

		if(\dash\request::get('price'))
		{
			$args['doyon.price'] = \dash\request::get('price');
			$filterArgs['price'] = \dash\request::get('price');
		}

		if(\dash\request::get('status'))
		{
			$args['doyon.status'] = \dash\request::get('status');
			$filterArgs['status'] = \dash\request::get('status');
		}

		if(\dash\request::get('donestatus'))
		{
			$args['doyon.donestatus'] = \dash\request::get('donestatus');
			$filterArgs['donestatus'] = \dash\request::get('donestatus');
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
			$args['1.1'] = [" = 1.1 ", " AND doyon.datecreated > '$startdate' AND doyon.datecreated < '$enddate'  "];
			$payment_args['1.1'] = [" = 1.1 ", " AND doyon.datecreated > '$startdate' AND doyon.datecreated < '$enddate'  "];

		}
		elseif($startdate)
		{
			$args['doyon.datecreated'] = [">", " '$startdate' "];
			$payment_args['doyon.datecreated'] = [">", " '$startdate' "];
		}
		elseif($enddate)
		{
			$args['doyon.datecreated'] = ["<", " '$enddate' "];
			$payment_args['doyon.datecreated'] = ["<", " '$enddate' "];
		}

		if($get_date_url)
		{
			\dash\data::getDateURL('&'. http_build_query($get_date_url));

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


		$dataTable = \lib\app\doyon::list($search_string, $args);

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_doyon', 'data' => $dataTable]);
		}

		\dash\data::dataTable($dataTable);

		\dash\data::sortLink(\content_m\view::make_sort_link(\lib\app\doyon::$sort_field, \dash\url::this()));
		$type_count = \lib\app\doyon::type_count($args);
		\dash\data::typeCount($type_count);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
