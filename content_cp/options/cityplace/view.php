<?php
namespace content_cp\options\cityplace;


class view extends \addons\content_cp\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		$this->data->page['special'] = true;
		$this->data->bodyclass       = 'unselectable siftal';


		$city_list = \lib\utility\location\cites::list('localname');
		$city_list = array_unique($city_list);
		$this->data->city_list = implode(',', $city_list);

		$this->data->way_list = \lib\app\travel::cityplace_list();
	}
}
?>
