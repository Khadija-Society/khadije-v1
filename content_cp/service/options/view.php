<?php
namespace content_cp\service\options;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Service request options");
		$this->data->page['desc']  = T_("check service request options and update requests");

		$this->data->page['badge']['link'] = \dash\url::here(). '/service';
		$this->data->page['badge']['text'] = T_('Back to service request list');

		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->need = \lib\app\need::list('expertise');

	}

	public function view_edit()
	{
		if(\dash\request::get('edit'))
		{
			$this->data->edit_mode = true;
			$id = \dash\request::get('edit');
			$this->data->product_detail = \lib\db\needs::get(['id' => $id, 'limit' => 1]);
			if(!$this->data->product_detail)
			{
				\lib\header::status(404, T_("Id not found"));
			}
		}
	}
}
?>
