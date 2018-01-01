<?php
namespace content_cp\options\donate;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");

		$this->data->page['special'] = true;
		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->way_list = \lib\app\donate::way_list();
	}
}
?>
