<?php
namespace content_a\service\request;


class controller extends \content_a\main\controller
{
	function ready()
	{
		if(!$this->login())
		{
			$this->redirector(\lib\url::base(). '/enter')->redirect();
			return;
		}

		$this->get()->ALL();
		$this->post('service')->ALL();
	}
}
?>
