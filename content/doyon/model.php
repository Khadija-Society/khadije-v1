<?php
namespace content\doyon;

class model
{
	public static function post()
	{

		\lib\app\doyon::add(\dash\request::post());

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>