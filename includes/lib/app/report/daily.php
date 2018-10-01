<?php
namespace lib\app\report;


class daily
{
	public static function last_30_days($_days = 30, $_sort = 'date', $_order = 'desc')
	{

		if(!in_array($_sort, ['date', 'sum']))
		{
			$_sort = 'date';
		}

		if(!in_array($_order, ['asc', 'desc']))
		{
			$_order = 'desc';
		}

		$result = \lib\db\report\daily::last_30_days($_days, $_sort, $_order);


		$return = [];

		$return['table'] = $result;

		$hi_chart               = [];
		$categories             = array_keys($result);
		$categories             = array_map(function ($_a){return \dash\datetime::fit($_a, null, 'date');}, $categories);
		$hi_chart['categories'] = json_encode($categories, JSON_UNESCAPED_UNICODE);
		$value                  = array_values($result);
		$value                  = array_map('intval', $value);
		$hi_chart['value']      = json_encode($value, JSON_UNESCAPED_UNICODE);

		$return['chart'] = $hi_chart;

		return $return;
	}
}
?>