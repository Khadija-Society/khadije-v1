<?php
namespace lib\app;


class report
{
	public static function whitname()
	{
		$query  = "SELECT sum(transactions.plus) AS `sum`, transactions.doners AS `doners` FROM transactions WHERE verify = 1 GROUP BY transactions.doners ORDER BY sum DESC";
		$result = \dash\db::get($query, ['doners', 'sum']);

		$temp = [];
		foreach ($result as $title => $xvalue)
		{
			if((string) $title === '0')
			{
				$temp[] = ['doners' => T_("Anonymous"), 'sum' => $xvalue];
			}
			elseif((string) $title === '1')
			{
				$temp[] = ['doners' => T_("Whit name"), 'sum' => $xvalue];
			}
		}

		return $temp;
	}

	public static function counttransaction()
	{
		$result  = [];
		$query   = "SELECT sum(transactions.plus) AS `sum`, transactions.payment AS `payment` FROM transactions WHERE verify = 1 GROUP BY transactions.payment";
		$payment = \dash\db::get($query, ['payment', 'sum']);

		foreach ($payment as $key => $value)
		{
			// $hazine_query = "SELECT sum(transactions.plus) AS `value`, transactions.hazinekard AS `title` FROM transactions  WHERE verify = 1 AND transactions.payment = '$key' GROUP BY transactions.hazinekard";
			// $pie          = \dash\db::get($hazine_query, ['title', 'value']);
			// $new_pie      = [];

			// foreach ($pie as $title => $xvalue)
			// {
			// 	$new_pie[] = ['title' => $title, 'value' => $xvalue];
			// }
			$new_pie = [];
			$result[] =
			[
				'payment' => T_(ucfirst($key)),
				'sum'     => $value,
				'pie'     => $new_pie,
			];
		}
		return $result;
	}

	public static function hazinekard()
	{

		$query  = "SELECT sum(transactions.plus) AS `sum`, transactions.hazinekard AS `hazinekard` FROM transactions WHERE verify = 1 GROUP BY transactions.hazinekard ORDER BY sum DESC";
		$result = \dash\db::get($query, ['hazinekard', 'sum']);
		$temp = [];
		foreach ($result as $title => $xvalue)
		{
			$temp[] = ['hazinekard' => $title, 'sum' => $xvalue];
		}

		return $temp;
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