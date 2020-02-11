<?php
namespace content\l\signup;


class controller
{
	public static function routing()
	{
		$lottery_id = \dash\url::subchild();
		$load = \lib\app\syslottery::get($lottery_id);
		if(!$lottery_id || !$load)
		{
			\dash\header::status(404);
		}

		if(isset($load['status']) && $load['status'] === 'enable')
		{
			// nothing
		}
		else
		{
			\dash\data::disableLottery(true);
		}

		\dash\data::myLottery($load);
		\dash\data::lotteryId($lottery_id);

		\dash\open::get();
		\dash\open::post();

		\dash\utility\hive::set();

	}
}
?>