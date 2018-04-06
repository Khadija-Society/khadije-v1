<?php
namespace content_a\group\home;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("List of your group request");
		$this->data->page['desc']  = T_('You can check your last request and cancel them or add new request');

		$this->data->page['badge']['link'] = \dash\url::here(). '/group/request';
		$this->data->page['badge']['text'] = T_('register for new group request');


		$this->data->group_list = \lib\app\travel::user_travel_list('group');

		if(!$this->data->group_list || empty($this->data->group_list))
		{
			\lib\redirect::to(\dash\url::here().'/group/request');
			return;
		}
	}
}
?>
