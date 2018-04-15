<?php
namespace content_a\trip\partner;


class controller extends \content_a\main\controller
{
	function ready()
	{
		\content_a\controller::check_trip_id();

		$this->post('partner')->ALL();
		$this->get()->ALL();
	}
}
?>
