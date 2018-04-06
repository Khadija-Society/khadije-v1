<?php
namespace content_a\service\detail;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new service request"). ' | '. T_('Step 3');
		$this->data->page['desc']  = T_('fill your request detail');

		$this->data->edit_mode = true;

		$id = \dash\request::get('id');

		$this->data->service_detail = null;

		if(is_numeric($id))
		{
			$this->data->service_detail = \lib\db\services::get(['id' => $id, 'user_id' => \dash\user::id(), 'limit' => 1]);
		}

		if(!$this->data->service_detail)
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}

}
?>
