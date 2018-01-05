<?php
namespace content_cp\nationalcode;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("National code list");
		$this->data->page['desc']  = T_("check nationalcode of persons and number of trips");

		$export_link = ' <a href="'. $this->url('baseFull'). '/nationalcode?export=true">'. T_("Export"). '</a>';
		$this->data->page['desc'] .= $export_link;

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/nationalcode/import';
		$this->data->page['badge']['text'] = T_('Import');


		$this->data->bodyclass       = 'unselectable siftal';

		$args =
		[
			'order'          => \lib\utility::get('order'),
			'sort'           => \lib\utility::get('sort'),
		];

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

		$this->data->nationalcode_list = \lib\app\nationalcode::list($search_string, $args);

		if($export)
		{
			\lib\utility\export::csv(['name' => 'export_trip', 'data' => $this->data->nationalcode_list]);
		}


		$this->data->sort_link = self::make_sort_link(\lib\app\nationalcode::$sort_field, $this->url('baseFull'). '/nationalcode');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
