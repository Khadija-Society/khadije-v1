<?php
namespace content_m\representation;


class view
{
	public static function config()
	{
		\dash\permission::access('cpRepresentationView');

		\dash\data::page_pictogram('coffee');

		\dash\data::page_title(T_("Representation request list"));
		\dash\data::page_desc(T_("check representation requests"));

		$export_link = ' <a href="'. \dash\url::here(). '/representation?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc() . $export_link);

		\dash\data::badge_link(\dash\url::here(). '/representation/options');
		\dash\data::badge_text(T_('Options'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		$args =
		[
			'order'          => \dash\request::get('order'),
			'sort'           => \dash\request::get('sort'),
			'limit' => 18,
		];

		if(\dash\request::get('print'))
		{
			$args['limit'] = 100;
		}

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\dash\request::get('status')) $args['services.status'] = \dash\request::get('status');
		if(\dash\request::get('representation')) $args['services.expert'] = \dash\request::get('representation');
		$args['services.type'] = 'representation';

		if(\dash\request::get('mobile'))
		{
			$mobile = \dash\utility\filter::mobile(\dash\request::get('mobile'));
			if($mobile)
			{
				$user_id = \dash\db\users::get_by_mobile($mobile);
				if(isset($user_id['id']))
				{
					$args['services.user_id'] = $user_id['id'];
				}
			}
		}

		if(!isset($args['services.status']))
		{
			$args['services.status']     = ["NOT IN", "('cancel', 'draft')"];
		}
		$search_string            = \dash\request::get('q');

		if(!$search_string) $search_string = null;

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}

		$export = false;
		if(\dash\request::get('export') === 'true')
		{
			$export = true;
			$args['pagenation'] = false;
		}

		$dataTable = \lib\app\service::list($search_string, $args);
		\dash\data::dataTable($dataTable);

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_service', 'data' => \dash\data::dataTable()]);
		}

		\dash\data::sortLink(\content_m\view::make_sort_link(\lib\app\service::$sort_field, \dash\url::here(). '/service'));
		$filterArray = $args;
		unset($filterArray['services.type']);
		unset($filterArray['limit']);

		if(isset($filterArray['services.status']))
		{
			if(is_string($filterArray['services.status']))
			{
				$filterArray[T_("Status")] = $filterArray['services.status'];
			}
			unset($filterArray['services.status']);
		}

		if(isset($filterArray['services.expert']))
		{
			$filterArray[T_("Representation")] = $filterArray['services.expert'];
			unset($filterArray['services.expert']);
		}
		if(isset($filterArray['services.user_id']))
		{
			$filterArray[T_("Mobile")] = isset($dataTable[0]['mobile']) ? $dataTable[0]['mobile'] : null;
			unset($filterArray['services.user_id']);
		}

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

		$get = \dash\request::get();
		$get['print'] = 1;
		\dash\data::printListLink(\dash\url::this(). '?'. http_build_query($get));
		$get['print'] = null;
		\dash\data::rawListLink(\dash\url::this(). '?'. http_build_query($get));
	}
}
?>
