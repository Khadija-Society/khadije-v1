<?php
namespace content_cp\trip\options;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Request options");
		$this->data->page['desc']  = T_("change request options");

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/trip';
		$this->data->page['badge']['text'] = T_('Back to request list');


		$this->data->bodyclass          = 'unselectable siftal';

		$this->data->active_city        = \lib\app\travel::active_city();
		$this->data->trip_master_active = \lib\app\travel::trip_master_active();
		$this->data->trip_count_partner = \lib\app\travel::trip_count_partner();
		$this->data->trip_max_awaiting  = \lib\app\travel::trip_max_awaiting();
		$this->data->trip_getdate       = \lib\app\travel::trip_getdate();


	}
}
?>
