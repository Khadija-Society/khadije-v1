<?php
namespace content_cp\trip\view;


class controller extends \content_cp\main2\controller
{
	function ready()
	{


		$this->post('trip')->ALL();

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{
			$this->get()->ALL();
		}
		else
		{
			\dash\header::status(403, T_("Id not found"));
		}
	}
}
?>
