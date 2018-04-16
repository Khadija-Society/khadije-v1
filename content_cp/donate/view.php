<?php
namespace content_cp\donate;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Donation list"));
		\dash\data::page_desc(T_("check last donates and monitor all donate transaction"));

		$export_link = ' <a href="'. \dash\url::here(). '/donate?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc(). $export_link);

		\dash\data::badge_link(\dash\url::here(). '/donate/options');
		\dash\data::badge_text(T_('Options'));

		\dash\data::bodyclass('unselectable siftal');

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

		if(\dash\request::get('hazinekard'))
		{
			$args['hazinekard'] = \dash\request::get('hazinekard');
		}

		$args['donate']    = 'cash';
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

		\dash\data::donateList(\dash\app\transaction::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => \dash\data::donateList()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sortLink(\dash\app\transaction::$sort_field, \dash\url::here(). '/donate'));

		\dash\data::totalPaid(\dash\app\transaction::total_paid());
		\dash\data::totalPaidDate(\dash\app\transaction::total_paid_date(date("Y-m-d")));

	}
}
?>
