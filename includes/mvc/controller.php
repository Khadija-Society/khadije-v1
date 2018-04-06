<?php
namespace mvc;

class controller extends \lib\controller
{
	public function project()
	{
		if(\dash\url::directory() === 'main')
		{
			\lib\redirect::to(\dash\url::here());
			\lib\header::status(404);
		}
	}
}
?>
