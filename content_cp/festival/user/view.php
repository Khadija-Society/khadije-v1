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
			$args['sort'] = 'id';
		}

		if(\dash\request::get('mobile'))
		{
			$mobile = \dash\request::get('mobile');
			$user_id = \dash\db\users::get_by_mobile($mobile);
			if(isset($user_id['id']))
			{
				$args['user_id'] = $user_id['id'];
			}
		}

		if(\dash\request::get('course'))
		{
			$args['course'] = \dash\request::get('course');
		}

		$args['festivalusers.festival_id']             = \dash\coding::decode(\dash\request::get('id'));

		$search_string      = \dash\request::get('q');

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}

		$dataTable = \lib\app\festivaluser::list($search_string, $args);

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\festivaluser::$sort_field, \dash\url::this(). '/transaction'));

		\dash\data::dataTable($dataTable);


		$filterArray = $args;
		unset($filterArray['festivalusers.festival_id']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
