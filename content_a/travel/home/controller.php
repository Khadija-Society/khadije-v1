<?php
namespace content_a\travel\home;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->post('travel')->ALL();
		$this->get()->ALL();
	}
}
?>
