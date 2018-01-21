<?php
namespace content_cp\staticvar;


class controller extends \content_cp\main2\controller
{
	function ready()
	{

		$this->post('staticvar')->ALL();
		$this->get()->ALL();
	}
}
?>
