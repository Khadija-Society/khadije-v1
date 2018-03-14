<?php
namespace content_a\trip\home;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("List of your trip request");
		$this->data->page['desc']  = T_('You can check your last request and cancel them or add new request');

		$this->data->page['badge']['link'] = \lib\url::here(). '/trip/request';
		$this->data->page['badge']['text'] = T_('register for new trip request');


		$this->data->trip_list = \lib\app\travel::user_travel_list('family');

		if(!$this->data->trip_list || empty($this->data->trip_list))
		{
			$this->redirector(\lib\url::here().'/trip/request')->redirect();
			return;
		}
	}
}
?>
