<?php
namespace content_festival\home;


class view
{
	public static function config()
	{
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

	}
}
?>
