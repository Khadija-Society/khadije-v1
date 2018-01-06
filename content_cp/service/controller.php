<?php
namespace content_cp\service;


class controller extends \content_cp\main2\controller
{
	function ready()
	{

		$this->post('service')->ALL();
		$this->get()->ALL();
	}
}
?>
