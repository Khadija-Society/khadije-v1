<?php
namespace content_a\trip\request;


class controller extends \content_a\main\controller
{
	function ready()
	{
		if(!$this->login())
		{
			\lib\redirect::to(\lib\url::base(). '/enter');
			return;
		}

		$this->get()->ALL();
		$this->post('trip')->ALL();
	}
}
?>
