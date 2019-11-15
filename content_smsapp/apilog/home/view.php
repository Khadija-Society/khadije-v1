<?php
namespace content_smsapp\apilog\home;


class view
{
	public static function config()
	{
		if(!\dash\permission::supervisor())
		{
			\dash\header::status(403);
		}

		$myTitle = T_("Log");
		$myDesc  = T_('Check list of log and search or filter in them to find your logs.');

		// add back level to summary link
		$product_list_link =  '<a href="'. \dash\url::here() .'" data-shortkey="121">'. T_('Back to dashboard'). '</a>';
		$myDesc .= ' | '. $product_list_link;

		\dash\data::page_title($myTitle);
		\dash\data::page_desc($myDesc);


		\dash\data::page_pictogram('pinboard');

		self::search_log();

	}

	public static function search_log($_args = [])
	{

		$search_string = \dash\request::get('q');
		if($search_string)
		{
			$myTitle .= ' | '. T_('Search for :search', ['search' => $search_string]);
		}

		$args =
		[
			'sort'   => \dash\request::get('sort'),
			'order'  => \dash\request::get('order'),
			// 'urlmd5' => ["IN", "('fd8d5ca88d7b4b2da40e6eb4520e8a17', 'afe31e33293521d1fa5361aeaaec13bc', '7a9dd4d851cc1cff7241e67dfc813dde', '6eb8850fd8a4d0005d5053511d9f8ba0')"],
		];

		if($_args && is_array($_args))
		{
			$args = array_merge($args, $_args);
		}

		if(!$args['sort'])
		{
			$args['sort'] = 'id';
		}

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}


		$where =
		[
			'user_id',
			'token',
			'apikey',
			'appkey',
			'zoneid',
			'subdomain',
			'version',
			'urlmd5',
			'method',
			'headerlen',
			'bodylen',
			'datesend',
			'pagestatus',
			'resultstatus',
			'dateresponse',
			'notif',
			'responselen',
		];

		foreach ($where as $key => $value)
		{
			if(\dash\request::get($value))
			{
				$args[$value] = \dash\request::get($value);
			}

		}


		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(!$args['sort'])
		{
			$args['sort'] = 'id';
		}


		$dataTable = \dash\db\apilog::search(\dash\request::get('q'), $args);

		\dash\data::dataTable($dataTable);

		$filterArray = $args;

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);
	}
}
?>