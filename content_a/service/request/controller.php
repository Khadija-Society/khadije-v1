<?php
namespace content_a\service\request;


class controller extends \content_a\main\controller
{
	function ready()
	{
		if(!\lib\user::login())
		{
			\lib\redirect::to(\dash\url::base(). '/enter');
			return;
		}

		$this->get()->ALL();
		$this->post('service')->ALL();
	}
}
?>
