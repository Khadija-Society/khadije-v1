<?php
namespace content_cp\consulting;


class view
{
	public static function config()
	{
		\dash\permission::access('cpConsultingView');

		\dash\data::page_pictogram('chat-alt-fill');

		\dash\data::page_title(T_("Consulting request list"));
		\dash\data::page_desc(T_("check consulting requests"));

		$export_link = ' <a href="'. \dash\url::here(). '/consulting?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc() . $export_link);

		\dash\data::badge_link(\dash\url::here(). '/consulting/options');
		\dash\data::badge_text(T_('Options'));

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

		if(\dash\request::get('status')) $args['services.status'] = \dash\request::get('status');
		if(\dash\request::get('consulting')) $args['services.expert'] = \dash\request::get('consulting');
		$args['services.type'] = 'consulting';

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

		\dash\data::dataTable(\lib\app\service::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_service', 'data' => \dash\data::dataTable()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\service::$sort_field, \dash\url::here(). '/service'));
		$filterArray = $args;

		if(isset($filterArray['services.status']))
		{
			if(is_string($filterArray['services.status']))
			{
				$filterArray[T_("Status")] = $filterArray['services.status'];
			}
			unset($filterArray['services.status']);
		}


		unset($filterArray['services.type']);
		if(isset($filterArray['services.expert']))
		{
			$filterArray[T_("Consulting")] = $filterArray['services.expert'];
			unset($filterArray['services.expert']);
		}
		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);
	}
}
?>
