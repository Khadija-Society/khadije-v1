<?php
namespace content_cp\options\cityplace;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		$this->data->page['special'] = true;
		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->city_list = \lib\app\travel::city_list();

		$this->data->way_list = \lib\app\travel::cityplace_list();
	}
}
?>
