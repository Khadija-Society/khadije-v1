<?php
namespace content_cp\trip\options;


class controller extends \addons\content_cp\main\controller
{
	function ready()
	{
		$this->post('options')->ALL();
		$this->get()->ALL();
	}
}
?>
