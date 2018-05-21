<?php
namespace content_delneveshte\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Heart Writing"));
		\dash\data::page_desc(\dash\data::site_desc());
		\dash\data::include_css(false);
		\dash\data::include_js(false);

		$args =
		[
			'sort'  => \dash\request::get('sort'),
			'order' => \dash\request::get('order'),
		];

		// $args['status'] = 'aproved';

		$args['type'] = 'delneveshte';


		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(!$args['sort'])
		{
			$args['sort'] = 'id';
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\comment::$sort_field, \dash\url::this()));
		\dash\data::dataTable(\dash\app\comment::list(null, $args));
	}
}
?>
