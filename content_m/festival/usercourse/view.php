<?php
namespace content_m\festival\usercourse;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		$id     = \dash\request::get('id');
		$id     = \dash\coding::decode($id);

		$fuseid = \dash\request::get('festivaluser');
		$fuseid = \dash\coding::decode($fuseid);

		if(!$id || !$fuseid)
		{
			\dash\header::status(403, T_("Invalid id"));
		}

		$load = \lib\db\festivalusers::get(['id' => $fuseid, 'festival_id' => $id, 'limit' => 1]);

		if(!$load)
		{
			\dash\header::status(403, T_("Festival user detail not found"));
		}

		$load = array_map(['\lib\app\festivaluser', 'ready'], [$load]);
		if(isset($load[0]))
		{
			$load = $load[0];
			\dash\data::dataRow($load);
		}

		if(isset($load['user_id']))
		{
			\dash\data::dataRowUser(\dash\db\users::get_by_id($load['user_id']));
		}

		if(isset($load['festivalcourse_id']))
		{
			\dash\data::dataRowCourse(\lib\db\festivalcourses::get(['id' => $load['festivalcourse_id'], 'limit' => 1]));
		}


	}
}
?>
