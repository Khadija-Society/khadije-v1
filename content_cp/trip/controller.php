<?php
namespace content_cp\trip;


class controller extends \content_cp\main2\controller
{
	function ready()
	{

		$this->post('trip')->ALL();
		$this->get()->ALL();
	}
}
?>
