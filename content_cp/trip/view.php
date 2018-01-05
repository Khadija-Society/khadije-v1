<?php
namespace content_cp\trip;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Request list");
		$this->data->page['desc']  = T_("check request and update status of each request");

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/trip/options';
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

		if(\lib\utility::get('status')) $args['travels.status'] = \lib\utility::get('status');
		if(\lib\utility::get('type')) $args['travels.type']     = \lib\utility::get('type');
		if(\lib\utility::get('place')) $args['travels.place']   = \lib\utility::get('place');

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

		$this->data->trip_list = \lib\app\travel::list($search_string, $args);

		if($export)
		{
			\lib\utility\export::csv(['name' => 'export_trip', 'data' => $this->data->trip_list]);
		}

		$this->data->sort_link = self::make_sort_link(\lib\app\travel::$sort_field, $this->url('baseFull'). '/trip');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
