<?php
namespace content_cp\donate;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Donation list");
		$this->data->page['desc']  = T_("check last donates and monitor all donate transaction");

		$export_link = ' <a href="'. \dash\url::here(). '/donate?export=true">'. T_("Export"). '</a>';
		$this->data->page['desc'] .= $export_link;

		$this->data->page['badge']['link'] = \dash\url::here(). '/donate/options';
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

		if(!$args['sort'])
		{
			$args['sort'] = 'dateverify';
		}

		$args['donate'] = 'cash';
		$args['condition'] = 'ok';
		$search_string            = \dash\request::get('q');

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

		$this->data->donate_list = \dash\app\transaction::list($search_string, $args);

		if($export)
		{
			\lib\utility\export::csv(['name' => 'export_trip', 'data' => $this->data->donate_list]);
		}


		$this->data->sort_link = self::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::here(). '/donate');

		$this->data->total_paid = \dash\app\transaction::total_paid();
		$this->data->total_paid_date = \dash\app\transaction::total_paid_date(date("Y-m-d"));

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
