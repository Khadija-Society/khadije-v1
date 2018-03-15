<?php
namespace content_cp\trip;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Request list");
		$this->data->page['desc']  = T_("check request and update status of each request");

		$export_link = ' <a href="'. \lib\url::here(). '/trip?export=true">'. T_("Export"). '</a>';
		$this->data->page['desc'] .= $export_link;

		$this->data->page['badge']['link'] = \lib\url::here(). '/trip/options';
		$this->data->page['badge']['text'] = T_('Options');

		$this->data->bodyclass       = 'unselectable siftal';

		$args =
		[
			'order'          => \lib\request::get('order'),
			'sort'           => \lib\request::get('sort'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\lib\request::get('status')) $args['travels.status']           = \lib\request::get('status');
		if(\lib\request::get('type')) $args['travels.type']               = \lib\request::get('type');
		if(\lib\request::get('place')) $args['travels.place']             = \lib\request::get('place');
		if(\lib\request::get('gender')) $args['users.gender']             = \lib\request::get('gender');
		if(\lib\request::get('birthday')) $args['YEAR(users.birthday)'] = \lib\request::get('birthday');

		if(!isset($args['travels.status']))
		{
			$args['travels.status'] = ["NOT IN", "('cancel', 'draft')"];
		}

		$search_string            = \lib\request::get('q');

		if($search_string)
		{
			$this->data->page['title'] = T_('Search'). ' '.  $search_string;
		}

		$export = false;
		if(\lib\request::get('export') === 'true')
		{
			$export = true;
			$args['pagenation'] = false;
		}

		$this->data->trip_list = \lib\app\travel::list($search_string, $args);

		if($export)
		{
			\lib\utility\export::csv(['name' => 'export_trip', 'data' => $this->data->trip_list]);
		}

		$this->data->sort_link = self::make_sort_link(\lib\app\travel::$sort_field, \lib\url::here(). '/trip');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
