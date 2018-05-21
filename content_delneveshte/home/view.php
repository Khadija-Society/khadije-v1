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

		$args           = [];
		$args['status'] = 'approved';
		$args['type']   = 'delneveshte';
		$args['limit']  = 100;
		$args['order']  = 'DESC';
		$args['sort']   = 'id';

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\comment::$sort_field, \dash\url::this()));

		$list = \dash\app\comment::list(null, $args);

		$delneveshte = [];
		if(isset($_SESSION['delneveshte']))
		{
			$delneveshte = $_SESSION['delneveshte'];
			$delneveshte = array_reverse($delneveshte);
		}

		\dash\data::dataTable(array_merge($delneveshte, $list));
	}
}
?>
