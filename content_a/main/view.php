<?php
namespace content_a\main;


class view extends \mvc\view
{
	public function repository()
	{
		$this->data->bodyclass = 'fixed unselectable siftal';
	}

	public function fix_value($_data)
	{
		if(isset($_data['birthday']))
		{
			$_data['birthday'] = \dash\utility\jdate::to_gregorian($_data['birthday']);
		}
		return $_data;
	}

}
?>
