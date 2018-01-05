<?php
namespace content_a\group\profile;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->check_trip_id('group');

		$this->post('profile')->ALL();
		$this->get()->ALL();
	}
}
?>
