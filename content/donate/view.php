<?php
namespace content\donate;

class view extends \mvc\view
{
	function config()
	{
		$this->data->bodyclass = 'unselectable vflex';
		$this->data->way_list  = \lib\app\donate::way_list();
	}
}
?>