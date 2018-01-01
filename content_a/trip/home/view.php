<?php
namespace content_a\trip\home;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];
		// $this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		// $this->data->page['special'] = true;

		$this->data->trip_list = \lib\app\travel::user_travel_list();

		if(!$this->data->trip_list || empty($this->data->trip_list))
		{
			$this->redirector($this->url('baseFull').'/trip/request')->redirect();
			return;
		}
	}
}
?>
