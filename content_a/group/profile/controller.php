<?php
namespace content_a\group\profile;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->check_group_id();

		$this->post('profile')->ALL();
		$this->get()->ALL();
	}
}
?>
