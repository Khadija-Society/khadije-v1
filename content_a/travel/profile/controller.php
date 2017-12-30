<?php
namespace content_a\travel\profile;


class controller extends \content_a\main\controller
{
	function ready()
	{

		$this->post('profile')->ALL();
		$this->get()->ALL();
	}
}
?>
