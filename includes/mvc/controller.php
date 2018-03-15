<?php
namespace mvc;

class controller extends \lib\controller
{
	public function project()
	{
		if(\lib\url::directory() === 'main')
		{
			$this->redirector(\lib\url::here())->redirect();
			\lib\error::page();
		}
	}
}
?>
