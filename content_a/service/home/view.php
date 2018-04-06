<?php
namespace content_a\service\home;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("List of your service request");
		$this->data->page['desc']  = T_('You can check your last request and cancel them or add new request');

		$this->data->page['badge']['link'] = \dash\url::here(). '/service/request';
		$this->data->page['badge']['text'] = T_('register for new service request');


		$this->data->service_list = \lib\app\service::user_service_list();

		if(!$this->data->service_list || empty($this->data->service_list))
		{
			\dash\redirect::to(\dash\url::here().'/service/request');
			return;
		}
	}
}
?>
