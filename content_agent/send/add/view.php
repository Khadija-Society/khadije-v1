<?php
namespace content_agent\send\add;


class view
{
	public static function config()
	{

		\dash\data::page_title("افزودن اعزام جدید". \dash\data::xCityTitlePage());

		\dash\data::page_pictogram('tools');

		\dash\data::badge_link(\dash\url::here(). '/servant/sortlist'. \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));


		$job = \dash\request::get('job');
		if($job && !in_array($job, ['clergy', 'admin', 'missionary', 'servant', 'adminoffice','maddah','rabet', 'khadem', 'nazer']))
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

		$sid = \dash\request::get('sid');
		if($sid)
		{
			$servantDetail = \lib\app\servant::get($sid);
			\dash\data::servantDetail($servantDetail);
		}

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


		if(\dash\request::get('place'))
		{
			$default_place = \lib\app\agentplace::get(\dash\request::get('place'));
			\dash\data::defaultPlace($default_place);
			if(!$city && \dash\data::defaultPlace_city())
			{
				$city = \dash\data::defaultPlace_city();
			}
		}

		\dash\data::myCity($city);

		\dash\data::placeList($place_list);

		$servant_args = ['pagenation' => false];
		if($city)
		{
			$servant_args['agent_servant.city'] = $city;
		}

		$RohaniList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'clergy']));
		\dash\data::RohaniList($RohaniList);

		$modirList  = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'admin']));;
		\dash\data::modirList($modirList);

		$negahbanList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'servant']));;
		\dash\data::negahbanList($negahbanList);


		$moballeqeList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'missionary']));
		\dash\data::moballeqeList($moballeqeList);

		$servantList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'adminoffice']));
		\dash\data::servantList($servantList);


		$maddahList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'maddah']));
		\dash\data::maddahList($maddahList);

		$rabetList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'rabet']));
		\dash\data::rabetList($rabetList);

		$nazerList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'nazer']));
		\dash\data::nazerList($nazerList);


		$khademList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'khadem']));
		\dash\data::khademList($khademList);

	}
}
?>