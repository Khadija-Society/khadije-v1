<?php
namespace content_cp\nationalcode;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("National code list");
		$this->data->page['desc']  = T_("check nationalcode of persons and number of trips");

		$export_link = ' <a href="'. \dash\url::here(). '/nationalcode?export=true">'. T_("Export"). '</a>';
		$this->data->page['desc'] .= $export_link;

		$this->data->page['badge']['link'] = \dash\url::here(). '/nationalcode/import';
		$this->data->page['badge']['text'] = T_('Import');


		$this->data->bodyclass       = 'unselectable siftal';

		$args =
		[
			'order'          => \dash\request::get('order'),
			'sort'           => \dash\request::get('sort'),
		];

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

		$this->data->nationalcode_list = \lib\app\nationalcode::list($search_string, $args);

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => $this->data->nationalcode_list]);
		}


		$this->data->sort_link = self::make_sort_link(\lib\app\nationalcode::$sort_field, \dash\url::here(). '/nationalcode');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
