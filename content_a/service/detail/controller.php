<?php
namespace content_a\service\detail;


class controller extends \content_a\main\controller
{
	function ready()
	{
		\content_a\controller::check_service_id();

		$this->post('detail')->ALL();
		$this->get()->ALL();
	}
}
?>
