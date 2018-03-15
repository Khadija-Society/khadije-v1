<?php
namespace content_cp\trip\view;


class controller extends \content_cp\main2\controller
{
	function ready()
	{


		$this->post('trip')->ALL();

		if(\lib\request::get('id') && is_numeric(\lib\request::get('id')))
		{
			$this->get()->ALL();
		}
		else
		{
			\lib\error::access(T_("Id not found"));
		}
	}
}
?>
