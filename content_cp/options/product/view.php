<?php
namespace content_cp\options\product;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		$this->data->page['special'] = true;

		$this->data->page['badge']['link'] = $this->url('baseFull'). '/options/product';
		$this->data->page['badge']['text'] = T_('Add new need');

		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->need = \lib\app\need::list('product');

	}

	public function view_edit()
	{
		if(\lib\utility::get('edit'))
		{
			$this->data->edit_mode = true;
			$id = \lib\utility::get('edit');
			$this->data->product_detail = \lib\db\needs::get(['id' => $id, 'limit' => 1]);
			if(!$this->data->product_detail)
			{
				\lib\error::page(T_("Id not found"));
			}
		}
	}
}
?>
