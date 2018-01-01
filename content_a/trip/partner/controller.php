<?php
namespace content_a\trip\partner;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->check_trip_id();

		$this->post('partner')->ALL();

		if(\lib\utility::get('edit'))
		{
			$this->get(false, 'edit')->ALL();
		}
		else
		{
			$this->get()->ALL();
		}
	}
}
?>
