<?php
namespace content_cp\nationalcode;


class controller extends \content_cp\main2\controller
{
	function ready()
	{

		$this->post('nationalcode')->ALL();
		$this->get()->ALL();
	}
}
?>
