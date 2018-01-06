<?php
namespace content_a\service\home;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->post('service')->ALL();
		$this->get()->ALL();
	}
}
?>
