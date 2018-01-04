<?php
namespace content_cp\trip\view;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");

		$this->data->page['special'] = true;

		// $this->data->page['badge']['link'] = $this->url('baseFull'). '/options/product';
		// $this->data->page['badge']['text'] = T_('Add new need');

		$this->data->bodyclass       = 'unselectable siftal';

		$this->data->travel_detail = \lib\db\travels::search(null, ['travels.id' => \lib\utility::get('id'), 'pagenation' => false]);
		if(isset($this->data->travel_detail[0]))
		{
			$this->data->travel_detail = $this->data->travel_detail[0];
		}

		$this->data->travel_partner = \lib\db\travelusers::get_travel_child(\lib\utility::get('id'));

		// load partner detail
		if(\lib\utility::get('partner') && is_numeric(\lib\utility::get('partner')))
		{
			$this->data->edit_mode = true;

			if(is_array($this->data->travel_partner))
			{
				foreach ($this->data->travel_partner as $key => $value)
				{
					if(isset($value['id']) && intval($value['id']) === intval(\lib\utility::get('partner')))
					{
						$this->data->partner_detail = $value;
						break;
					}
				}
			}

		}

	}
}
?>
