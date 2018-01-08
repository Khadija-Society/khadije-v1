<?php
namespace content\doners;

class controller extends \mvc\controller
{
	function ready()
	{
		$this->get()->ALL();
	}
}
?>