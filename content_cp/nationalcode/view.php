<?php
namespace content_cp\nationalcode;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Nationalcode list");
		$this->data->page['desc']  = T_("check nationalcode and update value of each nationalcode");

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

		$this->data->nationalcode_list = \lib\app\nationalcode::list($search_string, $args);

		$this->data->sort_link = self::make_sort_link(\lib\app\nationalcode::$sort_field, $this->url('baseFull'). '/nationalcode');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
