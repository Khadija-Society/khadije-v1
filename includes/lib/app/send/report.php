<?php
namespace lib\app\send;

class report
{

	public static function chart_servant_status($_city)
	{
		$result     = \lib\db\send\report::chart_servant_status($_city);
		$hi_chart   = [];

		if(!is_array($result))
		{
			$result = [];
		}

		foreach ($result as $key => $value)
		{
			$name  = null;
			$count = 0;

			if(array_key_exists('job', $value))
			{
				$name = $value['job'] ? T_($value['job']) : T_("No name");
			}

			if(array_key_exists('count', $value))
			{
				$count = intval($value['count']);
			}
			$newValue = ['name' => $name, 'y' => $count];
			if(!$value['job'])
			{
				$newValue['visible'] = false;
			}
			$hi_chart[] = $newValue;
		}

		$hi_chart = json_encode($hi_chart, JSON_UNESCAPED_UNICODE);

		return $hi_chart;

	}



	public static function chart_place_send($_city)
	{
		$result     = \lib\db\send\report::chart_place_send($_city);
		$hi_chart   = [];

		if(!is_array($result))
		{
			$result = [];
		}

		foreach ($result as $key => $value)
		{
			$name  = null;
			$count = 0;

			if(array_key_exists('place', $value))
			{
				$name = $value['place'] ? T_($value['place']) : T_("No name");
			}

			if(array_key_exists('count', $value))
			{
				$count = intval($value['count']);
			}
			$newValue = ['name' => $name, 'y' => $count];
			if(!$value['place'])
			{
				$newValue['visible'] = false;
			}
			$hi_chart[] = $newValue;
		}

		$hi_chart = json_encode($hi_chart, JSON_UNESCAPED_UNICODE);

		return $hi_chart;

	}


	public static function lastYear($_city)
	{
		$now = date("Y-m-d", strtotime("+30 days"));
		$lastYear = date("Y-m-d", strtotime("-1 year"));

		$get_chart_receive = \lib\db\send\report::get_chart($now, $lastYear, $_city);


		if(!is_array($get_chart_receive))
		{
			return false;
		}


		$date = array_keys($get_chart_receive);

		$hi_chart               = [];
		$hi_chart['categories'] = [];
		$hi_chart['receive']    = [];

		foreach ($date as $key => $value)
		{
			array_push($hi_chart['categories'], \dash\datetime::fit($value, null, 'date'));

			if(isset($get_chart_receive[$value]))
			{
				array_push($hi_chart['receive'], intval($get_chart_receive[$value]));
			}
			else
			{
				array_push($hi_chart['receive'], 0);
			}


		}

		$hi_chart['categories'] = json_encode($hi_chart['categories'], JSON_UNESCAPED_UNICODE);
		$hi_chart['receive']    = json_encode($hi_chart['receive'], JSON_UNESCAPED_UNICODE);
		return $hi_chart;
	}







}
?>
