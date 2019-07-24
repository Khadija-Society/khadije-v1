<?php
namespace content_m\delneveshte\home;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDelneveshteView');

		\dash\data::page_title(T_("Deleneveshteha"));
		\dash\data::page_desc(T_('Check list of delneveshte and search or filter in them to find your delneveshte.'). ' '. T_('Also add or edit specefic delneveshte.'));
		\dash\data::page_pictogram('heart-o');

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
			$args['comments.status'] = \dash\request::get('status');
		}

		if(!isset($args['status']))
		{
			$args['comments.status']     = ["NOT IN", "('cancel', 'draft', 'deleted')"];
		}

		$args['comments.type'] = 'delneveshte';

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

		\dash\data::sortLink(\content_m\view::make_sort_link(\dash\app\comment::$sort_field, \dash\url::this()));
		\dash\data::dataTable(\lib\app\delneveshte::list(\dash\request::get('q'), $args));

		$filterArray = $args;
		unset($filterArray['comments.type']);
		if(isset($filterArray['comments.status']))
		{
			if(is_string($filterArray['comments.status']))
			{
				$filterArray[T_("Status")] = $filterArray['comments.status'];
			}
			unset($filterArray['comments.status']);
		}

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);


	}
}
?>