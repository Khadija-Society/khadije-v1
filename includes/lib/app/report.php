<?php
namespace lib\app;


class report
{
	public static function key_value($_data, $_json = false)
	{
		if(!is_array($_data))
		{
			$_data = [];
		}

		$temp = [];

		foreach ($_data as $key => $value)
		{
			$temp[] = ['key' => $key, 'value' => $value];
		}

		if($_json)
		{
			$temp = json_encode($temp, JSON_UNESCAPED_UNICODE);
		}

		return $temp;
	}


	public static function tdate_key($_data, $_format = 'Y/m/d', $_convert = false)
	{
		if(!is_array($_data))
		{
			$_data = [];
		}

		$temp = [];

		foreach ($_data as $key => $value)
		{
			if(\dash\data::lang_current() == 'fa')
			{
				$new_key = \dash\utility\jdate::date($_format, $key, $_convert);
			}
			else
			{
				$new_key = date($_format, strtotime($key));
			}

			$temp[$new_key] = $value;
		}

		return $temp;
	}
}
?>