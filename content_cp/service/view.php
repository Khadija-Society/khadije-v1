<?php
namespace content_cp\service;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Service request list");
		$this->data->page['desc']  = T_("check service requests");

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/service/options';
		$this->data->page['badge']['text'] = T_('Options');

		$this->data->bodyclass       = 'unselectable siftal';

		$args =
		[
			'order'          => \lib\utility::get('order'),
			'sort'           => \lib\utility::get('sort'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\lib\utility::get('status')) $args['services.status'] = \lib\utility::get('status');
		if(\lib\utility::get('type')) $args['services.type']     = \lib\utility::get('type');

		$search_string            = \lib\utility::get('q');

		if($search_string)
		{
			$this->data->page['title'] = T_('Search'). ' '.  $search_string;
		}

		$export = false;
		if(\lib\utility::get('export') === 'true')
		{
			$export = true;
			$args['pagenation'] = false;
		}

		$this->data->service_list = \lib\app\service::list($search_string, $args);

		if($export)
		{
			\lib\utility\export::csv(['name' => 'export_service', 'data' => $this->data->service_list]);
		}

		$this->data->sort_link = self::make_sort_link(\lib\app\service::$sort_field, $this->url('baseFull'). '/service');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
