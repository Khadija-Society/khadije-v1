<?php
namespace content_u\home;


class controller extends \content_u\main\controller
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
