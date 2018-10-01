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
				$temp[] = ['doners' => T_("Anonymous"), 'sum' => intval($xvalue)];
			}
			elseif((string) $title === '1')
			{
				$temp[] = ['doners' => T_("Whit name"), 'sum' => intval($xvalue)];
			}
		}

		$hi_chart               = [];
		$hi_chart['raw']        = $temp;
		$hi_chart['categories'] = json_encode(array_column($temp, 'doners'), JSON_UNESCAPED_UNICODE);
		$hi_chart['value']      = json_encode(array_column($temp, 'sum'), JSON_UNESCAPED_UNICODE);
		return $hi_chart;

	}

	public static function counttransaction()
	{
		$result                 = [];
		$query                  = "SELECT sum(transactions.plus) AS `sum`, transactions.payment AS `payment` FROM transactions WHERE verify = 1 GROUP BY transactions.payment";
		$payment                = \dash\db::get($query, ['payment', 'sum']);

		$hi_chart               = [];
		$hi_chart['raw']        = $payment;
		$categories             = array_keys($payment);
		$categories             = array_map('ucfirst', $categories);
		$categories             = array_map('T_', $categories);
		$hi_chart['categories'] = json_encode($categories, JSON_UNESCAPED_UNICODE);
		$value                  = array_values($payment);
		$value                  = array_map('intval', $value);
		$hi_chart['value']      = json_encode($value, JSON_UNESCAPED_UNICODE);


		return $hi_chart;
	}

	public static function hazinekard()
	{

		$query  = "SELECT sum(transactions.plus) AS `sum`, transactions.hazinekard AS `hazinekard` FROM transactions WHERE verify = 1 GROUP BY transactions.hazinekard ORDER BY sum DESC";
		$result = \dash\db::get($query, ['hazinekard', 'sum']);
		$temp = [];
		foreach ($result as $title => $xvalue)
		{
			$temp[] = ['hazinekard' => $title, 'sum' => intval($xvalue)];
		}
		$hi_chart = [];
		$hi_chart['raw'] = $result;
		$hi_chart['categories'] = json_encode(array_column($temp, 'hazinekard'), JSON_UNESCAPED_UNICODE);
		$hi_chart['value'] = json_encode(array_column($temp, 'sum'), JSON_UNESCAPED_UNICODE);

		return $hi_chart;
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