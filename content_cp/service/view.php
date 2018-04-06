<?php
namespace content_cp\service;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Service request list");
		$this->data->page['desc']  = T_("check service requests");

		$export_link = ' <a href="'. \dash\url::here(). '/service?export=true">'. T_("Export"). '</a>';
		$this->data->page['desc'] .= $export_link;

		$this->data->page['badge']['link'] = \dash\url::here(). '/service/options';
		$this->data->page['badge']['text'] = T_('Options');

		$this->data->bodyclass       = 'unselectable siftal';

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


		$search_string            = \dash\request::get('q');

		if(!$search_string) $search_string = null;

		if($search_string)
		{
			$this->data->page['title'] = T_('Search'). ' '.  $search_string;
		}

		$export = false;
		if(\dash\request::get('export') === 'true')
		{
			$export = true;
			$args['pagenation'] = false;
		}

		$this->data->service_list = \lib\app\service::list($search_string, $args);

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_service', 'data' => $this->data->service_list]);
		}

		$this->data->sort_link = self::make_sort_link(\lib\app\service::$sort_field, \dash\url::here(). '/service');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
