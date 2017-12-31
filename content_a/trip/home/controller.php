<?php
namespace content_a\trip\home;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->post('trip')->ALL();
		$this->get()->ALL();
	}
}
?>
