<?php
namespace content_cp\options\trip;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		$this->data->page['special'] = true;
		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->active_city = \lib\app\travel::active_city();

	}
}
?>
