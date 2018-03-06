<?php
namespace content_a\trip\profile;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new trip request"). ' | '. T_('Step 2');
		$this->data->page['desc']  = T_('fill your personal data in this step'). ' '. T_('In next step fill your partner data');

		// $this->data->page['badge']['link'] = $this->url('baseFull'). '/trip';
		// $this->data->page['badge']['text'] = T_('check your trip requests');


		$this->data->userdetail      = \lib\db\users::get(['id' => \lib\user::id(), 'limit' => 1]);
		$this->data->userdetail = $this->fix_value($this->data->userdetail);
		$this->static_var();
	}


	public function static_var()
	{
		$country_list = \lib\utility\location\countres::list('name', 'name - localname');
		$this->data->country_list = implode(',', $country_list);

		$city_list = \lib\utility\location\cites::list('localname');
		$city_list = array_unique($city_list);
		$this->data->city_list = implode(',', $city_list);

		$provice_list = \lib\utility\location\provinces::list('localname');
		$provice_list = array_unique($provice_list);
		$this->data->provice_list = $provice_list;
	}
}
?>
