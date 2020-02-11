<?php
namespace content_lottery\user\l;

class view
{

	public static function config()
	{

		\dash\data::page_pictogram('atom');
		\dash\data::page_title('فرایند قرعه کشی | '. \dash\data::myLottery_title());


		\dash\data::badge_text(T_('Back'));
		\dash\data::badge_link(\dash\url::here());


		$lottery_list = \lib\app\lotterywin::get_list(\dash\data::myLotteryId());
		\dash\data::lotteryList($lottery_list);

	}
}
?>