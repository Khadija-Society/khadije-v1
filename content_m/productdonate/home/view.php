<?php
namespace content_m\productdonate\home;


class view
{
	public static function config()
	{
		\dash\permission::access('mProductView');

		\dash\data::page_title(T_("products donate list"));

		\dash\data::page_pictogram('broadcast');

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