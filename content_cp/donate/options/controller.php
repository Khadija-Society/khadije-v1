<?php
namespace content_cp\donate\options;


class controller extends \addons\content_cp\main\controller
{
	function ready()
	{
		$this->post('donate')->ALL();
		$this->get()->ALL();
	}
}
?>
