<?php
namespace content_cp\donate;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Nationalcode list");
		$this->data->page['desc']  = T_("check donate and update value of each donate");

		$this->data->bodyclass       = 'unselectable siftal';

		$args =
		[
			'order'          => \lib\utility::get('order'),
			'sort'           => \lib\utility::get('sort'),
		];

		$args['donate'] = 'cash';

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

		$this->data->donate_list = \lib\app\transaction::list($search_string, $args);

		if($export)
		{
			\lib\utility\export::csv(['name' => 'export_trip', 'data' => $this->data->donate_list]);
		}


		$this->data->sort_link = self::make_sort_link(\lib\app\transaction::$sort_field, $this->url('baseFull'). '/donate');

		$this->data->total_paid = \lib\app\transaction::total_paid();
		$this->data->total_paid_date = \lib\app\transaction::total_paid_date(date("Y-m-d"));

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
