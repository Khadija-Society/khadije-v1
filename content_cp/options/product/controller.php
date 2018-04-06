<?php
namespace content_cp\options\product;


class controller extends \addons\content_cp\main\controller
{
	function ready()
	{

		$this->post('product')->ALL();
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
