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
		$sort = \dash\request::get('sort');
		if(!$sort)
		{
			$args['sort']   = 'id';
			$args['order']  = 'DESC';
		}
		elseif($sort && !in_array($sort, ['last', 'maxlike', 'rand']))
		{
			$args['sort']   = 'id';
			$args['order']  = 'DESC';
		}
		else
		{
			switch ($sort)
			{
				case 'last':
					$args['sort']   = 'datecreated';
					$args['order']  = 'DESC';
					break;

				case 'maxlike':
					$args['sort']   = 'plus';
					$args['order']  = 'DESC';
					break;

				case 'rand':
					$args['sort']       = null;
					$args['order_rand'] = true;
					break;
			}
		}


		$args['status'] = 'approved';
		$args['type']   = 'delneveshte';
		$args['limit']  = 100;

		\dash\data::sortLink(\content_cms\view::make_sort_link(\dash\app\comment::$sort_field, \dash\url::this()));

		$list = \dash\app\comment::list(null, $args);

		$delneveshte = [];
		if(isset($_SESSION['delneveshte']))
		{
			$delneveshte = $_SESSION['delneveshte'];
			$delneveshte = array_reverse($delneveshte);
		}

		\dash\data::dataTable(array_merge($delneveshte, $list));


		\dash\data::display_delneveshte("content_delneveshte/home/layout.html");
		if(\dash\request::ajax())
		{
			\dash\data::display_delneveshte("content_delneveshte/home/messages.html");
		}

		if(isset($_SESSION['delneveshte_like']))
		{
			\dash\data::likes($_SESSION['delneveshte_like']);
		}

	}
}
?>
