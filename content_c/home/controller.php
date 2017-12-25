<?php
namespace content_c\home;


class controller extends \content_c\main\controller
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
