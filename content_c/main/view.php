<?php
namespace content_c\main;


class view extends \mvc\view
{
	public function repository()
	{
		$this->data->bodyclass = 'fixed unselectable siftal';
		$this->include->chart  = true;

		$this->data->display['khadijeControlLayout'] = 'content_c/main/layout.html';
	}
}
?>
