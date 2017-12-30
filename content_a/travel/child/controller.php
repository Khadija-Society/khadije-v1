<?php
namespace content_a\travel\child;


class controller extends \content_a\main\controller
{
	function ready()
	{
		$this->post('child')->ALL();

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
