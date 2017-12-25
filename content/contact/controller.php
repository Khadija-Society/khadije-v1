<?php
namespace content\contact;

class controller extends \mvc\controller
{
	function ready()
	{
		$this->post("contact")->ALL("/contact/");
	}
}
?>