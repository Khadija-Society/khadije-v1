<?php
namespace content_a\group\partner;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->check_trip_id('group');

		$this->post('partner')->ALL();
		$this->get()->ALL();
	}
}
?>
