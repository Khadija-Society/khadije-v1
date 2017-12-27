<?php
namespace content_a\profile;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		$this->data->page['special'] = true;

		$this->data->userdetail = \lib\db\users::get(['id' => \lib\user::id(), 'limit' => 1]);


	}
}
?>
