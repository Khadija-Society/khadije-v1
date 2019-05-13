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
}
?>
