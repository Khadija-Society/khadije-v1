<?php
namespace content_a\trip\add;


class controller extends \content_a\main\controller
{
	function ready()
	{
		if(!$this->login())
		{
			$this->redirector($this->url('base'). '/enter')->redirect();
			return;
		}

		$this->post('trip')->ALL();

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
