<?php
namespace content_api\v6\smsapp;


class sync
{

	public static function fire()
	{
		$input = self::get_input();
		if($input === false)
		{
			return false;
		}

		$result                = [];
		$result['status']      = \content_api\v6\smsapp\controller::status();
		$result['dashboard']   = \content_api\v6\smsapp\dashboard::get();
		$result['queue']       = \content_api\v6\smsapp\queue::get();
		$result['smsnewsaved'] = [];

		if(isset($input['smsnew']) && is_array($input['smsnew']))
		{
			foreach ($input['smsnew'] as $key => $value)
			{
				$temp             = [];
				$temp['smsid']    = isset($value['smsid']) ? $value['smsid'] : null;
				$temp['localid']  = isset($value['localid']) ? $value['localid'] : null;
				$temp['serverid'] = \content_api\v6\smsapp\newsms::multi_add_new_sms($value);

				$result['smsnewsaved'][] = $temp;
			}
		}

		if(isset($input['sentsms']) && is_array($input['sentsms']))
		{
			foreach ($input['sentsms'] as $key => $value)
			{
				$temp             = [];
				$temp['smsid']    = isset($value['smsid']) ? $value['smsid'] : null;
				$temp['localid']  = isset($value['localid']) ? $value['localid'] : null;
				$temp['serverid'] = isset($value['serverid']) ? $value['serverid'] : null;
				$temp['status']   = \content_api\v6\smsapp\sent::multi_set($value);

				$result['sentsmssaved'][] = $temp;
			}
		}

		return $result;
	}


	private static function get_input()
	{
		$get_input = @file_get_contents('php://input');
		if(!$get_input || !is_string($get_input))
		{
			\dash\notif::error(T_("No input was send!"));
			return false;
		}

		$get_input = json_decode($get_input, true);
		if(!is_array($get_input))
		{
			\dash\notif::error(T_("Invalid input syntax"));
			return false;
		}

		if(!$get_input)
		{
			\dash\notif::error(T_("Empty input"));
			return false;
		}

		return $get_input;

	}
}
?>