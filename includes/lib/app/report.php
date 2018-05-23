<?php
namespace lib\app;


class report
{
	public static function counttransaction()
	{
		$result  = [];
		$query   = "SELECT sum(transactions.plus) AS `sum`, transactions.payment AS `payment` FROM transactions GROUP BY transactions.payment";
		$payment = \dash\db::get($query, ['payment', 'sum']);

		foreach ($payment as $key => $value)
		{
			$hazine_query = "SELECT sum(transactions.plus) AS `value`, transactions.hazinekard AS `title` FROM transactions  where transactions.payment = '$key' GROUP BY transactions.hazinekard";
			$pie          = \dash\db::get($hazine_query, ['title', 'value']);
			$new_pie      = [];

			foreach ($pie as $title => $xvalue)
			{
				$new_pie[] = ['title' => $title, 'value' => $xvalue];
			}

			$result[] =
			[
				'payment' => T_($key),
				'sum'     => $value,
				'pie'     => $new_pie,
			];
		}
		return $result;
	}


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