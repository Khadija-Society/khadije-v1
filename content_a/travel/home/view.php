<?php
namespace content_a\travel\home;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];
		// $this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		// $this->data->page['special'] = true;

		$this->data->travel_list = \lib\app\travel::user_travel_list();

		if(!$this->data->travel_list || empty($this->data->travel_list))
		{
			$this->redirector($this->url('baseFull').'/travel/profile')->redirect();
			return;
		}
	}
}
?>
