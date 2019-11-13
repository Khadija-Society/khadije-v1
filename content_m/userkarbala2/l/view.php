<?php
namespace content_m\userkarbala2\l;

class view
{

	public static function config()
	{
		\dash\permission::access('koyeMohebbat');
		\dash\data::page_pictogram('atom');
		\dash\data::page_title('فرایند قرعه کشی');


		\dash\data::badge_text(T_('Back'));
		\dash\data::badge_link(\dash\url::this());


		$lottery_list = \lib\app\lottery::get_list('karbala2users');
		\dash\data::lotteryList($lottery_list);

	}
}
?>