<?php
namespace content\contact;

class view extends \mvc\view
{
	function config()
	{
		$this->data->page['title'] = T_("Contact Us");
		$this->data->page['desc']  = T_("We do our best to improve khadije's service quality.");

		$this->data->bodyclass = 'unselectable vflex';
	}
}
?>