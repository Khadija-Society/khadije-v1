<?php
namespace content_a\service\detail;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new service request"). ' | '. T_('Step 3');
		$this->data->page['desc']  = T_('fill your detail detail'). ' '. T_('detail can be family or friends'). ' '. T_('Also you can skip this step and register only for yours without detail');

		$this->data->edit_mode = true;

		$id = \lib\utility::get('id');

		$this->data->service_detail = null;

		if(is_numeric($id))
		{
			$this->data->service_detail = \lib\db\services::get(['id' => $id, 'user_id' => \lib\user::id(), 'limit' => 1]);
		}

		if(!$this->data->service_detail)
		{
			\lib\error::page(T_("Id not found"));
		}
	}

}
?>
