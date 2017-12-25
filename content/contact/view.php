<?php
namespace content\contact;

class view extends \mvc\view
{
	function config()
	{
		$this->data->page['title'] = T_("Contact Us");
		$this->data->page['desc'] = T_("Knowing your valuable comments about bugs and problems and more importantly your precious offers will help us in this way.");

		$this->data->bodyclass = 'unselectable vflex';
	}
}
?>