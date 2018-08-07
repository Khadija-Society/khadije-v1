<?php
namespace content_festival\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("جشنواره بانوی نبی پسند"));
		\dash\data::page_desc('طراح گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. ');
		\dash\data::include_css(false);
		\dash\data::include_js(false);

		\dash\data::display_festival("content_festival/home/layout.html");
		if(\dash\request::ajax())
		{
			\dash\data::display_festival("content_festival/home/messages.html");
		}

		$festival = \dash\data::festival();
		$festival_id = \dash\data::festival_id();

		$festival = array_map(['\lib\app\festival', 'ready'], [$festival]);
		$festival = $festival[0];

		if(!isset($festival['status']) || (isset($festival['status']) && $festival['status'] != 'enable'))
		{
			if(!\dash\permission::supervisor())
			{
				\dash\header::status(403, T_("This festival is not enable"));
			}
		}

		if(isset($festival['schedule']) && is_array($festival['schedule']))
		{
			foreach ($festival['schedule'] as $key => $value)
			{
				if(isset($value['schedule']) && $value['schedule'])
				{
					$date = $value['date']. ' '. $value['time'];
					$date = strtotime($date);
					if($date)
					{
						$timing = $date - time();

						if($timing > 0)
						{
							\dash\data::timing($timing);
						}
					}
				}
			}
		}

		\dash\data::festival($festival);
		$course = \lib\db\festivalcourses::get(['festival_id' => $festival_id]);
		if(is_array($course))
		{
			$course = array_map(['\lib\app\festivalcourse', 'ready'], $course);
		}
		\dash\data::course($course);

		$detail = \lib\db\festivaldetails::get(['festival_id' => $festival_id]);
		if(is_array($detail))
		{
			$detail = array_map(['\lib\app\festivaldetail', 'ready'], $detail);
		}

		$supporter      = [];
		$mediasupporter = [];
		$refree         = [];
		$organizer      = [];

		foreach ($detail as $key => $value)
		{
			if(isset($value['type']))
			{
				switch ($value['type'])
				{
					case 'supporter':
						array_push($supporter, $value);
						break;

					case 'mediasupporter':
						array_push($mediasupporter, $value);
						break;

					case 'refree':
						array_push($refree, $value);
						break;

					case 'organizer':
						array_push($organizer, $value);
						break;

				}
			}
		}
		\dash\data::supporter($supporter);
		\dash\data::mediasupporter($mediasupporter);
		\dash\data::refree($refree);
		\dash\data::organizer($organizer);

		// var_dump(\dash\data::get());exit();
	}
}
?>
