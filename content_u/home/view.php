<?php
namespace content_u\home;


class view extends \content_u\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		$this->data->page['special'] = true;

		$this->data->dateDetail      = \lib\utility\date::month_precent();

	}
}
?>
