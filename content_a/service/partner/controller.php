<?php
namespace content_a\service\partner;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->check_service_id();

		$this->post('partner')->ALL();
		$this->get()->ALL();
	}
}
?>
