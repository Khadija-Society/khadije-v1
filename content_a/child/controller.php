<?php
namespace content_a\child;


class controller extends \content_a\main\controller
{
	function ready()
	{
		if(!$this->login())
		{
			$this->redirector($this->url('base'). '/enter')->redirect();
			return;
		}

		$this->post('child')->ALL();
		$this->get()->ALL();
	}
}
?>
