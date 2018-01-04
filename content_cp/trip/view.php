<?php
namespace content_cp\trip;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("request list");
		$this->data->page['desc']  = T_("check request and update status of each request");


		$this->data->page['badge']['link'] = $this->url('baseFull'). '/trip/options';
		$this->data->page['badge']['text'] = T_('Options');


		// $this->data->page['badge']['link'] = $this->url('baseFull'). '/options/product';
		// $this->data->page['badge']['text'] = T_('Add new need');

		$this->data->bodyclass       = 'unselectable siftal';

		$args =
		[
			'order'          => \lib\utility::get('order'),
			'sort'           => \lib\utility::get('sort'),
			'in'             => \lib\utility::get('in'),
			'travels.status' => 'awaiting',
		];

		$search_string            = \lib\utility::get('q');

		if($search_string)
		{
			$this->data->page['title'] = T_('Search'). ' '.  $search_string;
		}

		$this->data->trip_list = \lib\app\travel::list($search_string, $args);

		$this->data->sort_link = self::make_sort_link(\lib\app\travel::$sort_field, $this->url('baseFull'). '/trip');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
