<?php
namespace content_cp\nationalcode\import;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Import national code");
		$this->data->page['desc']  = T_("Import list of national code, each line must have one nationalcode");

		$this->data->bodyclass       = 'unselectable siftal';

	}
}
?>
