<?php
namespace content_a\group\home;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->post('group')->ALL();
		$this->get()->ALL();
	}
}
?>
