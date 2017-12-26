<?php
namespace content_a\donate\product;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->post('donate')->ALL();
		$this->get()->ALL();
	}
}
?>
