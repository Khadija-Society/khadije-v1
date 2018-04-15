<?php
namespace content_cp\donate\options;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Donation options");
		$this->data->page['desc']  = T_("check and update some options on donations");

		$this->data->page['badge']['link'] = \dash\url::here(). '/donate';
		$this->data->page['badge']['text'] = T_('Back to donate list');


		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->wayList = \lib\app\donate::way_list();
	}
}
?>
