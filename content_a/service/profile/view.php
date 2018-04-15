<?php
namespace content_a\service\profile;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Register for new service request"). ' | '. T_('Step 2');
		$this->data->page['desc']  = T_('fill your personal data in this step'). ' '. T_('In next step fill your partner data');

		// $this->data->page['badge']['link'] = \dash\url::here(). '/service';
		// $this->data->page['badge']['text'] = T_('check your service requests');


		$this->data->userdetail      = \dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]);
		$this->data->userdetail = $this->fix_value($this->data->userdetail);
		$this->static_var();
	}


	public function static_var()
	{
		$countryList = \dash\utility\location\countres::list('name', 'name - localname');
		$this->data->countryList = implode(',', $countryList);

		$cityList = \dash\utility\location\cites::list('localname');
		$cityList = array_unique($cityList);
		$this->data->cityList = implode(',', $cityList);

		$proviceList = \dash\utility\location\provinces::list('localname');
		$proviceList = array_unique($proviceList);
		$this->data->proviceList = $proviceList;
	}
}
?>
