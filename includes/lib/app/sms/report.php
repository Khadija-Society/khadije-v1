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
}
?>
