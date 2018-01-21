<?php
namespace content_cp\staticvar;


class view extends \content_cp\main2\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Static var");
		$this->data->page['desc']  = T_("For show in home page");

		$this->data->bodyclass       = 'unselectable siftal';

		$url = root. 'public_html/files/data/staticvar.txt';

		$result = @\lib\utility\file::read($url);

		if(is_string($result))
		{
			$result          = explode("\n", $result);
			$temp            = [];
			$temp['qom']     = isset($result[0]) ? $result[0] : null;
			$temp['mashhad'] = isset($result[1]) ? $result[1] : null;
			$temp['karbala'] = isset($result[2]) ? $result[2] : null;
			$this->data->staticvar = $temp;
		}


	}
}
?>
