<?php
namespace content_a\trip\partner;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new trip request"). ' | '. T_('Step 3');
		$this->data->page['desc']  = T_('fill your partner detail'). ' '. T_('partner can be family or friends'). ' '. T_('Also you can skip this step and register only for yours without partner');

		// $this->data->page['badge']['link'] = \dash\url::here(). '/trip';
		// $this->data->page['badge']['text'] = T_('check your trip requests');


		$this->data->child_list = \lib\db\travelusers::get_travel_child(\dash\request::get('trip'));


  		$child_list =
  		[
	  		T_('Father'),
	  		T_('Mother'),
	  		T_('Sister'),
	  		T_('Brother'),
	  		T_('Grandfather'),
	  		T_('Grandmother'),
	  		T_('Aunt'),
	  		T_('Husband'),
	  		T_('Uncle'),
	  		T_('Boy'),
	  		T_('Girl'),
	  		T_('Spouse'),
	  		T_('Stepmother'),
	  		T_('Stepfather'),
	  		T_('Neighbor'),
	  		T_('Teacher'),
	  		T_('Friend'),
	  		T_('Boss'),
	  		T_('Supervisor'),
	  		T_('Child'),
	  		T_('Grandson'),
  		];

  		$this->data->nesbat_list = implode(',', $child_list);

	}


	public function view_edit()
	{
		$this->data->edit_mode = true;

		$id = \dash\request::get('edit');

		$this->data->child_detail = null;

		if(is_numeric($id))
		{
			$this->data->child_detail = \dash\db\users::get(['id' => $id, 'parent' => \dash\user::id(), 'limit' => 1]);
		}

		if(!$this->data->child_detail)
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>
