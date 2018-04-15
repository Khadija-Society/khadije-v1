<?php
namespace content_cp\trip;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Request list");
		$this->data->page['desc']  = T_("check request and update status of each request");

		$export_link = ' <a href="'. \dash\url::here(). '/trip?export=true">'. T_("Export"). '</a>';
		$this->data->page['desc'] .= $export_link;

		$this->data->page['badge']['link'] = \dash\url::here(). '/trip/options';
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

		if(\dash\request::get('status')) $args['travels.status']           = \dash\request::get('status');
		if(\dash\request::get('type')) $args['travels.type']               = \dash\request::get('type');
		if(\dash\request::get('place')) $args['travels.place']             = \dash\request::get('place');
		if(\dash\request::get('gender')) $args['users.gender']             = \dash\request::get('gender');
		if(\dash\request::get('birthday')) $args['YEAR(users.birthday)'] = \dash\request::get('birthday');

		if(!isset($args['travels.status']))
		{
			$args['travels.status'] = ["NOT IN", "('cancel', 'draft')"];
		}

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

		$this->data->tripList = \lib\app\travel::list($search_string, $args);

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => $this->data->tripList]);
		}

		$this->data->sortLink = self::make_sortLink(\lib\app\travel::$sort_field, \dash\url::here(). '/trip');

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}
}
?>
