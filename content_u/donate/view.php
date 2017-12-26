<?php
namespace content_u\donate;


class view extends \content_u\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		$this->data->page['special'] = true;

		$this->data->way_list = \lib\app\donate::way_list();

	}
}
?>
