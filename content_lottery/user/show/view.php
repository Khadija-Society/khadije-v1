<?php
namespace content_lottery\user\show;

class view
{

	public static function config()
	{
		\dash\data::page_pictogram('atom');
		\dash\data::page_title('نفرات انتخاب شده در این مرحله');


		\dash\data::badge_text(T_('Back'));
		\dash\data::badge_link(\dash\url::this(). '/l'. \dash\data::xLidStart());



		// md5 of level url
		$level = \dash\request::get('level');
		// 32 md5 and step level >= 32
		if(mb_strlen($level) >= 32)
		{
			$md5  = substr($level, 0, 32);
			$step = substr($level, 32);

			if($step && !is_numeric($step))
			{
				\dash\header::status(404, T_("Invalid step"));
				return false;
			}

			$load_level = \lib\app\lotterywin::load_lottery(\dash\data::myLotteryId(), $md5, 'a');
			\dash\data::allList($load_level);

			$lottery_detail = \dash\temp::get('myLotteryDetail');
			\dash\data::lotteryDetail($lottery_detail);


		}


	}
}
?>