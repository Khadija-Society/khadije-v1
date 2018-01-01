<?php
namespace content_cp\options\trip;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");

		$this->data->page['special'] = true;
		$this->data->bodyclass          = 'unselectable siftal';

		$this->data->active_city        = \lib\app\travel::active_city();
		$this->data->trip_master_active      = \lib\app\travel::trip_master_active();
		$this->data->trip_count_partner = \lib\app\travel::trip_count_partner();
		$this->data->trip_max_awaiting  = \lib\app\travel::trip_max_awaiting();
		$this->data->trip_getdate       = \lib\app\travel::trip_getdate();


	}
}
?>
