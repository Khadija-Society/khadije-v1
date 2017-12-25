<?php
namespace mvc;

class controller extends \lib\controller
{
	public function project()
	{
		if(\lib\router::get_url() === 'main')
		{
			$this->redirector($this->url('baseFull'))->redirect();
			\lib\error::page();
		}
	}
}
?>
