<?php
namespace content_cp\options\cityplace;


class controller extends \addons\content_cp\main\controller
{
	function ready()
	{
		$this->post('cityplace')->ALL();
		$this->get()->ALL();
	}
}
?>
