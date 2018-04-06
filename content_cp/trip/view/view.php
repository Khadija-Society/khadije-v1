<?php
namespace content_cp\trip\view;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("View request detail");
		$this->data->page['desc']  = T_("check request and update status");

		$this->data->page['badge']['link'] = \dash\url::here(). '/trip';
		$this->data->page['badge']['text'] = T_('Back to request list');

		$this->data->bodyclass = 'unselectable siftal';

		$this->data->travel_detail = \lib\db\travels::search(null, ['travels.id' => \lib\request::get('id'), 'pagenation' => false]);
		if(isset($this->data->travel_detail[0]))
		{
			$this->data->travel_detail = $this->data->travel_detail[0];
		}

		$this->data->travel_partner = \lib\db\travelusers::get_travel_child(\lib\request::get('id'));

		// load partner detail
		if(\lib\request::get('partner') && is_numeric(\lib\request::get('partner')))
		{
			$this->data->edit_mode = true;

			if(is_array($this->data->travel_partner))
			{
				foreach ($this->data->travel_partner as $key => $value)
				{
					if(isset($value['id']) && intval($value['id']) === intval(\lib\request::get('partner')))
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
