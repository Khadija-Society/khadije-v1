<?php
namespace content_a\trip\profile;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->check_trip_id();

		$this->post('profile')->ALL();
		$this->get()->ALL();
	}
}
?>
