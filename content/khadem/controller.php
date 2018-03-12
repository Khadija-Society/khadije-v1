<?php
namespace content\khadem;


class controller extends \mvc\controller
{
	function ready()
	{
		$this->get()->ALL();
	}
}
?>
