<?php
namespace content_cp\admincontact\home;


class view
{
	public static function config()
	{
		\dash\permission::access('cpAdminContactView');

		\dash\data::page_title(T_("Contact with manager"));
		\dash\data::page_desc(T_('Check list of admincontact and search or filter in them to find your admincontact.'). ' '. T_('Also add or edit specefic admincontact.'));
		\dash\data::page_pictogram('user-secret');

		// add back level to summary link
		\dash\data::badge2_text(T_('Back to dashboard'));
		\dash\data::badge2_link(\dash\url::here());


		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$args =
		[
			'sort'  => \dash\request::get('sort'),
			'order' => \dash\request::get('order'),
		];

		if(\dash\request::get('status'))
		{
			$args['status'] = \dash\request::get('status');
		}

		if(!isset($args['status']))
		{
			$args['status']     = ["NOT IN", "('cancel', 'draft', 'deleted')"];
		}


		$args['type'] = 'admincontact';

		if(\dash\request::get('unittype'))
		{
			$args['unittype'] = \dash\request::get('unittype');
		}

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(!$args['sort'])
		{
			$args['sort'] = 'id';
		}


		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\comment::$sort_field, \dash\url::this()));
		\dash\data::dataTable(\dash\app\comment::list(\dash\request::get('q'), $args));

		$filterArray = $args;
		unset($filterArray['type']);
		if(isset($filterArray['status']))
		{
			if(is_string($filterArray['status']))
			{
				$filterArray[T_("Status")] = $filterArray['status'];
			}
			unset($filterArray['status']);
		}

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);


	}
}
?>