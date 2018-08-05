<?php
namespace content_cp\festival\user;


class view
{
	public static function config()
	{
		\dash\permission::access('cpBookTransactionView');

		\dash\data::page_title(T_("Festival transaction"));
		\dash\data::page_desc(T_("check festival last transactions and monitor them"));
		\dash\data::page_pictogram('magic');

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

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

		if(\dash\request::get('festival'))
		{
			$args['hazinekard'] = \dash\request::get('festival');
		}

		$args['donate']    = 'festival';
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

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::here(). '/pricefestival'));

		if(\dash\permission::check('cpDonateTotalPay'))
		{
			\dash\data::totalPaid(\lib\db\mytransactions::total_paid(['donate' => 'festival']));
			\dash\data::totalPaidDate(\lib\db\mytransactions::total_paid(['donate' => 'festival'], true));
			\dash\data::totalPaidCount(\lib\db\mytransactions::total_paid(['donate' => 'festival'], false, true));
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
