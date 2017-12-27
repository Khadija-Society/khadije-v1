<?php
namespace content_a\profile;


class controller extends \content_a\main\controller
{
	function ready()
	{
		if(!$this->login())
		{
			$this->redirector($this->url('base'). '/enter')->redirect();
			return;
		}

		$this->post('profile')->ALL();
		$this->get()->ALL();
	}
}
?>
