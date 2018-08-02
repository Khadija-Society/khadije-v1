<?php
namespace content_cp\festival\schedule;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		if(\dash\request::post('type') === 'remove')
		{
			$date = \dash\request::post('date');

			$old = \dash\data::dataRow_schedule();
			if(!is_array($old))
			{
				$old = json_decode($old, true);
			}

			if(!is_array($old))
			{
				$old = [];
			}

			if(array_key_exists($date, $old))
			{
				unset($old[$date]);
			}
			else
			{
				\dash\notif::error(T_("Invalid date for remove"));
				return false;
			}

		}
		else
		{

			$title = \dash\request::post('title');
			$date  = \dash\request::post('date');
			$time  = \dash\request::post('time');

			if(!$title)
			{
				\dash\notif::error(T_("Please enter the title"), 'title');
				return false;
			}

			if(mb_strlen($title) > 200)
			{
				\dash\notif::error(T_("Please set the title less than 200 character"), 'title');
				return false;
			}

			if(!$date)
			{
				\dash\notif::error(T_("Please enter the date"), 'date');
				return false;
			}

			$date = \dash\date::db($date);
			if(!$date)
			{
				\dash\notif::error(T_("Invalid date"), 'date');
				return false;
			}

			if(\dash\utility\jdate::is_jalali($date))
			{
				$date = \dash\utility\jdate::to_gregorian($date);
			}

			$time = \dash\date::make_time($time);
			if($time === false)
			{
				\dash\notif::error(T_("Invalid time"), 'date');
				return false;
			}
			elseif($time === null)
			{
				$time = '08:00:00';
			}

			$old = \dash\data::dataRow_schedule();
			if(!is_array($old))
			{
				$old = json_decode($old, true);
			}

			if(!is_array($old))
			{
				$old = [];
			}

			$old["$date $time"] = $title;
		}

		$update             = [];
		$update['schedule'] = json_encode($old, JSON_UNESCAPED_UNICODE);
		$result             = \lib\app\festival::edit($update, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
