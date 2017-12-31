<?php
namespace content\donate;

class controller extends \mvc\controller
{
	function ready()
	{
		$this->get()->ALL();
		$this->post("donate")->ALL();
	}
}
?>