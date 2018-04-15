<?php
namespace content_a\donate\product;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];
		// $this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		// $this->data->page['special'] = true;

		$this->data->need = \lib\app\need::list('product');
		$this->data->wayList = \lib\app\donate::way_list();
	}
}
?>
