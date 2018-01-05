<?php
namespace content_a\group\request;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new group request"). ' | '. T_('Step 1');
		$this->data->page['desc']  = T_('in 3 simple step register your request for have group to holy places');

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/group';
		$this->data->page['badge']['text'] = T_('check your group requests');

		if(!\lib\app\travel::group_master_active('get'))
		{
			$this->data->signup_locked = true;
		}
		else
		{
			$this->data->cityplace_list = \lib\app\travel::active_city();
		}

	}
}
?>
