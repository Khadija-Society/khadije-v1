<?php
namespace content_a\trip\request;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];

		$this->data->cityplace_list = \lib\app\travel::active_city();
	}
}
?>
