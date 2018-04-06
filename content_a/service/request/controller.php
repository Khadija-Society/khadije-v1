<?php
namespace content_a\service\request;


class controller extends \content_a\main\controller
{
	function ready()
	{
		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::base(). '/enter');
			return;
		}

		$this->get()->ALL();
		$this->post('service')->ALL();
	}
}
?>
