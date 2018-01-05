<?php
namespace content_cp\nationalcode\edit;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Edit nationalcode");
		$this->data->page['desc']  = T_("Edit nationalcode here");

		$this->data->bodyclass       = 'unselectable siftal';

		if(\lib\utility::get('id') && is_numeric(\lib\utility::get('id')))
		{
			$this->data->nationalcode_detail = \lib\db\nationalcodes::get(['id' => \lib\utility::get('id'), 'limit' => 1]);
		}
	}
}
?>
