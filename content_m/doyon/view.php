<?php
namespace content_m\doyon;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDonateView');


		\dash\data::page_pictogram('lock');

		\dash\data::page_title(T_("Doyon list"));

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



		$search_string     = \dash\request::get('q');

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}


		$dataTable = \lib\app\doyon::list($search_string, $args);


		\dash\data::dataTable($dataTable);

		// \dash\data::sortLink(\content_m\view::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::here(). '/donate'));

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
