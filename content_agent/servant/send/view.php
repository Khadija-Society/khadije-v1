<?php
namespace content_agent\servant\send;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('tools');


		$job = \dash\request::get('job');
		if(!$job || !in_array($job, ['clergy', 'admin', 'missionary', 'servant']))
		{
			\dash\header::status(403, T_("Job"));
		}

		$city = \dash\request::get('city');

		if(!$city || !in_array($city, ['qom', 'mashhad', 'karbala']))
		{
			\dash\header::status(403, T_("City"));
		}

		$userDetail = \dash\app\user::get(\dash\request::get('user'));
		\dash\data::userDetail($userDetail);

		$args_place = [];
		$args_place['pagenation'] = false;
		if(isset($userDetail['gender']) && in_array($userDetail['gender'], ['male', 'female']))
		{
			$args_place['1.1'] = [' = 1.1', " AND (gender = 'all' or gender IS NULL or gender = '$userDetail[gender]')"];
		}


		$args_place['2.2'] = [' = 2.2', " AND (city IS NULL or city = '$city')"];


		$place_list = \lib\app\agentplace::list(null, $args_place);

		\dash\data::placeList($place_list);


	}
}
?>