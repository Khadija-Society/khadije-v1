<?php
namespace content_cp\book;


class view
{
	public static function config()
	{
		\dash\permission::access('cpBookTransactionView');

		\dash\data::page_pictogram('book');

		\dash\data::page_title(T_("Pay book list"));
		\dash\data::page_desc(T_("check last books and monitor all book transaction"));

		$export_link = ' <a href="'. \dash\url::here(). '/book?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc(). $export_link);

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

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
		}

		if(\dash\request::get('mobile'))
		{
			$args['mobile'] = \dash\request::get('mobile');
		}

		if(\dash\request::get('book'))
		{
			$args['hazinekard'] = \dash\request::get('book');
		}

		$args['donate']    = 'book';
		$args['condition'] = 'ok';
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

		\dash\data::dataTable(\dash\app\transaction::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => \dash\data::dataTable()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::here(). '/book'));

		if(\dash\permission::check('cpDonateTotalPay'))
		{
			\dash\data::totalPaid(\lib\db\mytransactions::total_paid(['donate' => 'book']));
			\dash\data::totalPaidDate(\lib\db\mytransactions::total_paid(['donate' => 'book'], true));
		}

		$filterArray = $args;
		unset($filterArray['donate']);
		unset($filterArray['condition']);
		if(isset($filterArray['hazinekard']))
		{
			$filterArray[T_("Book")] = $filterArray['hazinekard'];
			unset($filterArray['hazinekard']);
		}
		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
