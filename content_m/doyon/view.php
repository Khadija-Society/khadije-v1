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

		if(!\dash\permission::supervisor())
		{
			$args['doyon.status'] = 'pay';
		}


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


		$search_string     = \dash\request::get('q');

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}


		$dataTable = \lib\app\doyon::list($search_string, $args);


		\dash\data::dataTable($dataTable);

		\dash\data::sortLink(\content_m\view::make_sort_link(\lib\app\doyon::$sort_field, \dash\url::this()));
		$type_count = \lib\app\doyon::type_count();
		\dash\data::typeCount($type_count);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
