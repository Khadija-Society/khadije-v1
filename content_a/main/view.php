<?php
namespace content_a\main;


class view extends \mvc\view
{
	public function repository()
	{
		$this->data->bodyclass = 'fixed unselectable siftal';
		$this->include->chart  = true;

		$this->data->display['khadijeControlLayout'] = 'content_a/main/layout.html';
	}
}
?>
