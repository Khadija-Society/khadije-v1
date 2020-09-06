<?php
namespace lib\app;

/**
 * Class for protectionreport.
 */
class protectionreport
{

	public static function occasion_type()
	{
		$chart = [];

		$count = \lib\db\protectionreport::occasion_type_count();
		$chart['table_count'] = $count;

		$chart_count = [];
		foreach ($count as $key => $value)
		{
			$chart_count[] = ['name' => $value['type'], 'y' => floatval($value['count'])];
		}

		$chart['chart_count'] = json_encode($chart_count, JSON_UNESCAPED_UNICODE);

		$price = \lib\db\protectionreport::occasion_type_price();
		$chart['table_price'] = $price;

		$chart_price = [];
		foreach ($price as $key => $value)
		{
			$chart_price[] = ['name' => $value['type'], 'y' => floatval($value['total_price'])];
		}

		$chart['chart_price'] = json_encode($chart_price, JSON_UNESCAPED_UNICODE);



		return $chart;
	}

	public static function agent_type()
	{
		$chart = [];

		$count = \lib\db\protectionreport::agent_type_count();
		$chart['table_count'] = $count;

		$chart_count = [];
		foreach ($count as $key => $value)
		{
			$chart_count[] = ['name' => $value['type'], 'y' => floatval($value['count'])];
		}

		$chart['chart_count'] = json_encode($chart_count, JSON_UNESCAPED_UNICODE);

		$price = \lib\db\protectionreport::agent_type_price();
		$chart['table_price'] = $price;

		$chart_price = [];
		foreach ($price as $key => $value)
		{
			$chart_price[] = ['name' => $value['type'], 'y' => floatval($value['total_price'])];
		}

		$chart['chart_price'] = json_encode($chart_price, JSON_UNESCAPED_UNICODE);



		return $chart;
	}


	public static function province()
	{
		$chart = [];


		$price = \lib\db\protectionreport::agent_province_price();
		$price_table = [];
		foreach ($price as $key => $value)
		{
			$name = \dash\utility\location\provinces::get($value['province'], null, 'localname');
			$price_table[] = ['province_name' => $name, 'total_price' => $value['total_price']];
		}
		$chart['table_price'] = $price_table;

		$chart_price = [];
		foreach ($price as $key => $value)
		{
			$map_code = \dash\utility\location\provinces::get($value['province'], null, 'map_code');
			$chart_price[] = [$map_code, intval($value['total_price'])];
		}

		$chart['chart_price'] = json_encode($chart_price, JSON_UNESCAPED_UNICODE);


		return $chart;
	}

}
?>