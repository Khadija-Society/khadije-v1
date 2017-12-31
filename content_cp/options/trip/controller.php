<?php
namespace content_cp\options\trip;


class controller extends \addons\content_cp\main\controller
{
	function ready()
	{
		$this->post('trip')->ALL();
		$this->get()->ALL();
	}
}
?>
