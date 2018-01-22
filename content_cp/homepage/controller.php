<?php
namespace content_cp\homepage;


class controller extends \content_cp\main2\controller
{
	function ready()
	{

		$this->post('staticvar')->ALL();
		$this->get()->ALL();
	}
}
?>
