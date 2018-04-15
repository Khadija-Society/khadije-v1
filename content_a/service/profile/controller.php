<?php
namespace content_a\service\profile;


class controller extends \content_a\main\controller
{
	function ready()
	{
		\content_a\controller::check_service_id();

		$this->post('profile')->ALL();
		$this->get()->ALL();
	}
}
?>
