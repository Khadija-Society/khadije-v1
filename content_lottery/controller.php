<?php
namespace content_lottery;


class controller
{
	public static function lottery_id()
	{
		$lottery_id = \dash\request::get('lid');
		$load = \lib\app\syslottery::get($lottery_id);
		if(!$load)
		{
			\dash\header::status(404, T_("Invalid id"));

		}
		\dash\data::myLottery($load);
		\dash\data::myLotteryId(\dash\coding::decode($lottery_id));

	}


	public static function routing()
	{

		\dash\permission::access('contentLottery');

		if(\dash\url::module() === 'user')
		{
			self::lottery_id();

			$xLid = \dash\request::get('lid');

			$get = \dash\request::get();
			unset($get['lid']);

			if($get)
			{
				$start = '&';
			}
			else
			{
				$start = '?';
			}

			\dash\data::xLid($start. 'lid='. $xLid);
			\dash\data::xLidStart('?lid='. $xLid);
			\dash\data::xLidAnd('&lid='. $xLid);
		}




	}
}
?>
