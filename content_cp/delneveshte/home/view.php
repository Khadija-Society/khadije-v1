<?php
namespace content_cp\delneveshte\home;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDelneveshteView');

		\dash\data::page_title(T_("Deleneveshte"));
		\dash\data::page_desc(T_('Check list of delneveshte and search or filter in them to find your delneveshte.'). ' '. T_('Also add or edit specefic delneveshte.'));

		// $this->data->page['badge']['link'] = \dash\url::this(). '';
		// $this->data->page['badge']['text'] = T_('Add new :val', ['val' => $myType]);

		// add back level to summary link
		$product_list_link        =  '<a href="'. \dash\url::here() .'" data-shortkey="121">'. T_('Back to dashboard'). '</a>';
		\dash\data::page_desc(\dash\data::page_desc(). ' | '. $product_list_link);

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

		$args['type'] = 'delneveshte';

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
		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);


	}
}
?>