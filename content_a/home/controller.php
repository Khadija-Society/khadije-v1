<?php
namespace content_a\home;


class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{
		$this->get()->ALL();
	}
}
?>
