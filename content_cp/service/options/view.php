<?php
namespace content_cp\service\options;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Service request options");
		$this->data->page['desc']  = T_("check service request options and update requests");

		$this->data->page['badge']['link'] = \lib\url::here(). '/service';
		$this->data->page['badge']['text'] = T_('Back to service request list');

		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->need = \lib\app\need::list('expertise');

	}

	public function view_edit()
	{
		if(\lib\request::get('edit'))
		{
			$this->data->edit_mode = true;
			$id = \lib\request::get('edit');
			$this->data->product_detail = \lib\db\needs::get(['id' => $id, 'limit' => 1]);
			if(!$this->data->product_detail)
			{
				\lib\error::page(T_("Id not found"));
			}
		}
	}
}
?>
