<?php
namespace content_a\home;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];
		// $this->data->page['special'] = true;

		$this->data->dateDetail      = \lib\date::month_precent();

	}
}
?>
