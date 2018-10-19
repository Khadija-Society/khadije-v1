<?php
namespace content_cp\donate;


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


		\dash\data::badge2_link(\dash\url::here(). '/donate?export=true');
		\dash\data::badge2_text(T_("Export"));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		$payment_args = [];
		$payment_args['donate'] = 'cash';
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

		\dash\data::dataTable(\dash\app\transaction::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_donate', 'data' => \dash\data::dataTable()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::here(). '/donate'));

		if(\dash\permission::check('cpDonateTotalPay'))
		{
			\dash\data::totalPaid(\dash\app\transaction::total_paid($payment_args));
			\dash\data::totalPaidDate(\dash\app\transaction::total_paid_date(date("Y-m-d"), $payment_args));
			\dash\data::totalPaidCount(\dash\app\transaction::total_paid_count($payment_args));
		}

		$filterArray = $args;
		unset($filterArray['donate']);
		unset($filterArray['condition']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
