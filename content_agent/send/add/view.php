<?php
namespace content_agent\send\add;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title("افزودن اعزام جدید");

		\dash\data::page_pictogram('tools');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));


		$job = \dash\request::get('job');
		if($job && !in_array($job, ['clergy', 'admin', 'missionary', 'servant', 'adminoffice']))
		{
			\dash\header::status(403, T_("Job"));
		}

		$city = \dash\request::get('city');

		if($city && !in_array($city, ['qom', 'mashhad', 'karbala']))
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

		if($city)
		{
			$args_place['2.2'] = [' = 2.2', " AND (city IS NULL or city = '$city')"];
		}


		$place_list = \lib\app\agentplace::list(null, $args_place);

		\dash\data::placeList($place_list);

		$servant_args = ['pagenation' => false];
		if($city)
		{
			$servant_args['city'] = $city;
		}
		$RohaniList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'clergy']));
		\dash\data::RohaniList($RohaniList);

		$modirList  = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'admin']));;
		\dash\data::modirList($modirList);

		$negahbanList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'adminoffice']));;
		\dash\data::negahbanList($negahbanList);

		$moballeqeList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'missionary']));
		\dash\data::moballeqeList($moballeqeList);

		$servantList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'servant']));
		\dash\data::servantList($servantList);
	}
}
?>