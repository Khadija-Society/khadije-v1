<?php
namespace content_cp\donate;


class controller extends \content_cp\main2\controller
{
	function ready()
	{

		$this->post('donate')->ALL();
		$this->get()->ALL();
	}
}
?>
