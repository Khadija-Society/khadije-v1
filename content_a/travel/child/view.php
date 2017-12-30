<?php
namespace content_a\travel\child;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];
		// $this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		// $this->data->page['special'] = true;

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/child';
		$this->data->page['badge']['text'] = T_('Add new child');

		$this->data->child_list = \lib\db\users::get(['parent' => \lib\user::id()]);

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
