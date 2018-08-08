<?php
namespace content_festival\home;


class view
{
	public static function config()
	{
		\dash\data::include_css(false);
		\dash\data::include_js(false);

		\dash\data::display_festival("content_festival/home/layout.html");
		if(\dash\request::ajax())
		{
			\dash\data::display_festival("content_festival/home/messages.html");
		}

		if(\dash\data::allFestivalList())
		{
			$festivals = \dash\data::allFestivalList();


			$festivals = array_map(['\lib\app\festival', 'ready'], $festivals);


			\dash\data::page_title(T_("All festival"));
			\dash\data::page_desc(T_("All festival"));


		}
		else
		{
			self::config_festival();
		}
	}


	public static function config_festival()
	{


		$festival = \dash\data::festival();
		$festival_id = \dash\data::festival_id();

		$festival = array_map(['\lib\app\festival', 'ready'], [$festival]);
		$festival = $festival[0];

		if(!isset($festival['status']))
		{
			\dash\header::status(404, T_("This festival is not enable"));
		}

		if(in_array($festival['status'], ['enable', 'expire']))
		{
			// no problem
		}
		else
		{
			if(!\dash\permission::supervisor())
			{
				\dash\header::status(403, T_("This festival is not enable"));
			}
		}

		\dash\data::page_title(\dash\data::festival_title());
		\dash\data::page_desc(\dash\data::festival_desc());

		if(isset($festival['schedule']) && is_array($festival['schedule']))
		{
			foreach ($festival['schedule'] as $key => $value)
			{
				$date = $value['date']. ' '. $value['time'];
				$date = strtotime($date);
				$timing = $date - time();

				if($timing < 0)
				{
					// time last
					$festival['schedule'][$key]['time_last'] = true;
				}

				if(isset($value['schedule']) && $value['schedule'])
				{
					if($date)
					{

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
		$referee         = [];
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

					case 'referee':
						array_push($referee, $value);
						break;

					case 'organizer':
						array_push($organizer, $value);
						break;

				}
			}
		}
		\dash\data::supporter($supporter);
		\dash\data::mediasupporter($mediasupporter);
		\dash\data::referee($referee);
		\dash\data::organizer($organizer);

		// var_dump(\dash\data::get());exit();
	}
}
?>
