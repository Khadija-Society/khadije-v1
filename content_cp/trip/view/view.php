<?php
namespace content_cp\trip\view;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");

		$this->data->page['special'] = true;

		// $this->data->page['badge']['link'] = $this->url('baseFull'). '/options/product';
		// $this->data->page['badge']['text'] = T_('Add new need');

		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->travel_detail = \lib\db\travels::search(null, ['travels.id' => \lib\utility::get('id'), 'pagenation' => false]);

		$this->data->travel_partner = \lib\db\travelusers::get_travel_child(\lib\utility::get('id'));

	}
}
?>
