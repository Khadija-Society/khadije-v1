<?php
namespace content\karbala\l4;


class controller
{
	public static function routing()
	{
		\dash\utility\hive::set();
		$subchild = \dash\url::subchild();
		
		if($subchild)
		{
			$addr = __DIR__.'/file/'. $subchild. '.csv';
			if(is_file($addr))
			{
				$load = \dash\utility\import::csv($addr);
				$load = array_map(["\\lib\\app\\karbalauser", "ready"], $load);
				\dash\data::okList($load);
				\dash\open::get();
			}
			else
			{
				\dash\header::status(404);
			}
		}

	}
}
?>