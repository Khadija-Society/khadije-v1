<?php
namespace lib\app;

class doyon
{
	private static function get_file()
	{
		$get = [];
		$addr = root. '/includes/lib/doyon.json';
		if(is_file($addr))
		{
			$get = \dash\file::read($addr);
			$get = json_decode($get, true);
			if(!is_array($get))
			{
				$get = [];
			}
		}

		return $get;
	}


	public static function get_raw_list()
	{
		$list = self::get_file();
		return $list;
	}
}
?>
