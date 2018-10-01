<?php
namespace lib\app\report;


class month
{
	public static function monthly($_sort = 'date', $_order = 'desc')
	{
		if(!in_array($_sort, ['date', 'sum']))
		{
			$_sort = 'date';
		}

		if(!in_array($_order, ['asc', 'desc']))
		{
			$_order = 'desc';
		}

		$result = \lib\db\report\month::monthly($_sort, $_order);

		$return = [];

		$return['table'] = $result;

		$temp = [];
		foreach ($result as $key => $value)
		{
			$temp[$value['year']. '-'. $value['month']] = $value['sum'];
		}

		$hi_chart               = [];
		$categories             = array_keys($result);
		$categories             = array_map(function ($_a){return \dash\datetime::fit($_a, 'Y F');}, $categories);
		$hi_chart['categories'] = json_encode($categories, JSON_UNESCAPED_UNICODE);
		$value                  = array_values($temp);
		$value                  = array_map('intval', $value);
		$hi_chart['value']      = json_encode($value, JSON_UNESCAPED_UNICODE);

		$return['chart'] = $hi_chart;

		return $return;
	}
}
?>