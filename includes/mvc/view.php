<?php
namespace mvc;

class view extends \lib\view
{
	function project()
	{
		// define default value for global


		$this->data->site['title']           = T_("Khadije Charity");
		// if(\lib\url::isLocal())
		// {
		// 	$this->data->site['title']           = T_("Test");
		// }
		$this->data->site['desc']            = T_("Executor of first pilgrimage to the Ahl al-Bayt");
		$this->data->site['slogan']          = $this->data->site['desc'];

		$this->data->page['desc']            = $this->data->site['desc']. ' | '. $this->data->site['slogan'];

		$this->data->bodyclass               = 'unselectable';

		// for pushstate of main page
		$this->data->template['xhr']         = 'content/main/layout-xhr.html';

		$this->data->display['admin']        = 'content_a/main/layout.html';
		$this->data->template['social']      = 'content/template/social.html';
		$this->data->template['share']       = 'content/template/share.html';


		if(in_array(\lib\router::get_repository_name(), ['content']))
		{
			// get total uses
			$total_users                     = 10; // intval(\lib\db\userteams::total_userteam());
			$total_users                     = number_format($total_users);
			$this->data->total_users         = \lib\utility\human::number($total_users);
			$this->data->footer_stat         = T_("We help :count people to work beter!", ['count' => $this->data->total_users]);
		}

		// if you need to set a class for body element in html add in this value
		$this->data->bodyclass           = null;
	}
}
?>