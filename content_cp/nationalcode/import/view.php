<?php
namespace content_cp\nationalcode\import;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Import nationalcode");
		$this->data->page['desc']  = T_("Import nationalcode here");

		$this->data->bodyclass       = 'unselectable siftal';

	}
}
?>
