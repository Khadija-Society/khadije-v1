<?php
namespace content\khadem;


class view extends \mvc\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new service request"). ' | '. T_('Step 1');
		$this->data->page['desc']  = T_('in 3 simple step register your request for have service to holy places');

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/service';
		$this->data->page['badge']['text'] = T_('check your service requests');

		$this->data->service_need_list = \lib\db\needs::get(['type' => 'expertise', 'status' => 'enable']);

	}
}
?>
