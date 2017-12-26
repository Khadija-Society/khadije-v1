<?php
namespace content_u\donate\product;


class controller extends \content_u\main\controller
{
	function ready()
	{
		$this->post('donate')->ALL();
		$this->get()->ALL();
	}
}
?>
