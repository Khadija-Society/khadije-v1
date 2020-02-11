<?php
namespace content_lottery\user\home;

class view
{

	public static function config()
	{

		\dash\data::page_pictogram('users');
		\dash\data::page_title('ثبت‌نامی‌های - '. \dash\data::myLottery_title());
		\dash\data::page_desc(T_('Some detail about your users!'));

		\dash\data::page_desc(\dash\data::page_desc(). ' '. T_('Also add or edit specefic user.'));

		\dash\data::badge_text(T_('Back'));
		\dash\data::badge_link(\dash\url::here());



		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$args =
		[
			'sort'  => \dash\request::get('sort'),
			'order' => \dash\request::get('order'),
			'lottery_id' => \dash\data::myLotteryId(),
		];


		$sortLink = \dash\app\sort::make_sortLink(\dash\app\user::$sort_field, \dash\url::this());
		$dataTable = \lib\db\lottery_user::search(\dash\request::get('q'), $args);
		if(is_array($dataTable))
		{
			$dataTable = array_map(["\\lib\\app\\lottery_user", "ready"], $dataTable);
		}


		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['order']);
		unset($check_empty_datatable['lottery_id']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>