<?php
namespace content_cp\service\options;


class controller extends \content_cp\main2\controller
{
	function ready()
	{

		$this->post('service')->ALL();
		if(\dash\request::get('edit'))
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
