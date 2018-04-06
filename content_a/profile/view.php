<?php
namespace content_a\profile;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];
		// $this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		// $this->data->page['special'] = true;

		$this->data->userdetail      = \dash\db\users::get(['id' => \lib\user::id(), 'limit' => 1]);
		$this->data->userdetail = $this->fix_value($this->data->userdetail);

		$this->static_var();

	}

	public function static_var()
	{
		// $this->data->grade_list = \lib\utility\grade::list();
		$parent_list =
		[
			"father"              => T_("Father"),
			"mother"              => T_("Mother"),
			"sister"              => T_("Sister"),
			"brother"             => T_("Brother"),
			"grandfather"         => T_("Grandfather"),
			"grandmother"         => T_("Grandmother"),
			"aunt"                => T_("Aunt"),
			"husband of the aunt" => T_("Husband of the aunt"),
			"uncle"               => T_("Uncle"),
			"boy"                 => T_("Boy"),
			"girl"                => T_("Girl"),
			"spouse"              => T_("Spouse"),
			"stepmother"          => T_("Stepmother"),
			"stepfather"          => T_("Stepfather"),
			"neighbor"            => T_("Neighbor"),
			"teacher"             => T_("Teacher"),
			"friend"              => T_("Friend"),
			"boss"                => T_("Boss"),
			"supervisor"          => T_("Supervisor"),
			"child"               => T_("Child"),
			"grandson"            => T_("Grandson"),
		];
		$this->data->parent_list = implode(',' ,array_values($parent_list));

		$country_list = \dash\utility\location\countres::list('name', 'name - localname');
		$this->data->country_list = implode(',', $country_list);

		$city_list = \dash\utility\location\cites::list('localname');
		$city_list = array_unique($city_list);
		$this->data->city_list = implode(',', $city_list);

		$provice_list = \dash\utility\location\provinces::list('localname');
		$provice_list = array_unique($provice_list);
		$this->data->provice_list = implode(',', $provice_list);
	}
}
?>
