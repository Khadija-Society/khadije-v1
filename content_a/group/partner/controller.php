<?php
namespace content_a\group\partner;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->check_group_id();

		$this->post('partner')->ALL();
		$this->get()->ALL();
	}
}
?>
