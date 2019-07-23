<?php
namespace lib\app\sms;

class report
{

	public static function get_groupby($_gateway)
	{
		$result            = [];
		$result['send']    = \lib\db\sms::get_groupby_send($_gateway);
		$result['receive'] = \lib\db\sms::get_groupby_receive($_gateway);

		return $result;
	}

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
			$temp           = [];
			$temp['date']   = $value['date'];
			$temp['tdate']  = \dash\datetime::fit($value['date'], true);
			$temp['thdate'] = \dash\datetime::fit($value['date'], 'human', 'year');
			$temp['sum']    = $value['sum'];
			$temp['sms']    = intval($value['sms']);
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
				$name = $value['sendstatus'] ? T_($value['sendstatus']) : T_("Waiting to answer");
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

	public static function chart_recommend()
	{
		$result     = \lib\db\sms\report::chart_recommend();
		$hi_chart   = [];

		if(!is_array($result))
		{
			$result = [];
		}

		foreach ($result as $key => $value)
		{
			$name  = null;
			$count = 0;

			if(array_key_exists('recommend_title', $value))
			{
				$name = $value['recommend_title'] ? T_($value['recommend_title']) : T_("Not detected");
			}

			if(array_key_exists('count', $value))
			{
				$count = intval($value['count']);
			}
			$newValue = ['name' => $name, 'y' => $count];
			if(!$value['recommend_title'])
			{
				$newValue['visible'] = false;
			}
			$hi_chart[] = $newValue;
		}

		$hi_chart = json_encode($hi_chart, JSON_UNESCAPED_UNICODE);

		return $hi_chart;
	}

	public static function chart_group()
	{
		$result     = \lib\db\sms\report::chart_group();
		$hi_chart   = [];

		if(!is_array($result))
		{
			$result = [];
		}

		foreach ($result as $key => $value)
		{
			$name  = null;
			$count = 0;

			if(array_key_exists('group_title', $value))
			{
				$name = $value['group_title'] ? T_($value['group_title']) : T_("No group");
			}

			if(array_key_exists('count', $value))
			{
				$count = intval($value['count']);
			}
			$newValue = ['name' => $name, 'y' => $count];
			if(!$value['group_title'])
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
