<?php
namespace mvc;

class controller extends \lib\controller
{
	public function project()
	{
		if(\dash\url::directory() === 'main')
		{
			\dash\redirect::to(\dash\url::here());
			\dash\header::status(404);
		}
	}
}
?>
