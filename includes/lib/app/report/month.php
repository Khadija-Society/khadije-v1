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
		$result = $temp;

		$result = \lib\app\report::tdate_key($result, 'Y F', true);
		$result = \lib\app\report::key_value($result, true);

		$return['chart'] = $result;

		return $return;
	}
}
?>