<?php
namespace lib\app\sms;

class report
{
	public static function count_sms_day($_gateway = null)
	{
		$result = \lib\db\sms\report::count_sms_day($_gateway);
		if(!is_array($result))
		{
			$result = [];
		}

		$new = [];
		foreach ($result as $key => $value)
		{
			$temp          = [];
			$temp['date']  = $value['date'];
			$temp['tdate'] = \dash\datetime::fit($value['date'], true);
			$temp['thdate'] = \dash\datetime::fit($value['date'], 'human', 'year');
			$temp['sum']   = $value['sum'];
			$temp['sms']   = ceil(intval($value['sum']) / 70);
			$new[] = $temp;
		}

		return $new;
	}


	public static function answer_time()
	{
		$result      = \lib\db\sms\report::answer_time();
		$result      = intval($result);
		$new         = [];
		$new['sec']  = round(intval($result), 2);
		$new['min']  = round(intval($result) / 60, 2);
		$new['hour'] = round(intval($result) / 60 / 60, 2);
		return $new;
	}

	public static function chart_sendstatus()
	{
		$result     = \lib\db\sms\report::chart_sendstatus();
		$hi_chart   = [];

		if(!is_array($result))
		{
			$result = [];
		}

		foreach ($result as $key => $value)
		{
			$name  = null;
			$count = 0;

			if(array_key_exists('sendstatus', $value))
			{
				$name = $value['sendstatus'] ? T_($value['sendstatus']) : T_("Null");
			}

			if(array_key_exists('count', $value))
			{
				$count = intval($value['count']);
			}
			$newValue = ['name' => $name, 'y' => $count];
			if(!$value['sendstatus'])
			{
				$newValue['visible'] = false;
			}
			$hi_chart[] = $newValue;
		}

		$hi_chart = json_encode($hi_chart, JSON_UNESCAPED_UNICODE);

		return $hi_chart;

	}

	public static function chart_receivestatus()
	{
		$result     = \lib\db\sms\report::chart_receivestatus();
		$hi_chart   = [];

		if(!is_array($result))
		{
			$result = [];
		}

		foreach ($result as $key => $value)
		{
			$name  = null;
			$count = 0;

			if(array_key_exists('receivestatus', $value))
			{
				$name = $value['receivestatus'] ? T_($value['receivestatus']) : T_("Null");
			}

			if(array_key_exists('count', $value))
			{
				$count = intval($value['count']);
			}
			$newValue = ['name' => $name, 'y' => $count];
			if(!$value['receivestatus'])
			{
				$newValue['visible'] = false;
			}
			$hi_chart[] = $newValue;
		}

		$hi_chart = json_encode($hi_chart, JSON_UNESCAPED_UNICODE);

		return $hi_chart;
	}
}
?>
