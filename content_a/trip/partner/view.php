<?php
namespace content_a\trip\partner;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new trip request"). ' | '. T_('Step 3');
		$this->data->page['desc']  = T_('fill your partner detail'). ' '. T_('partner can be family or friends'). ' '. T_('Also you can skip this step and register only for yours without partner');

		// $this->data->page['badge']['link'] = $this->url('baseFull'). '/trip';
		// $this->data->page['badge']['text'] = T_('check your trip requests');


		$this->data->child_list = \lib\db\travelusers::get_travel_child(\lib\utility::get('trip'));
	}


	public function view_edit()
	{
		$this->data->edit_mode = true;

		$id = \lib\utility::get('edit');

		$this->data->child_detail = null;

		if(is_numeric($id))
		{
			$this->data->child_detail = \lib\db\users::get(['id' => $id, 'parent' => \lib\user::id(), 'limit' => 1]);
		}

		if(!$this->data->child_detail)
		{
			\lib\error::page(T_("Id not found"));
		}
	}
}
?>
