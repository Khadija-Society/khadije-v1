<?php
namespace content\doners;

class view extends \mvc\view
{
	function config()
	{
		$this->data->page['title'] = T_("Doners");
		$this->data->page['desc']  = T_("List of our last doners");


		$this->data->bodyclass = 'unselectable vflex';
		$this->data->way_list  = \lib\app\donate::way_list();

		$this->data->DonersList = \lib\db\mytransactions::transaction_list();

	}
}
?>