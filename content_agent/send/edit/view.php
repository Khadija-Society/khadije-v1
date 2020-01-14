<?php
namespace content_agent\send\edit;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('tools');


		$args_place = [];
		$args_place['pagenation'] = false;

		$place_list = \lib\app\agentplace::list(null, $args_place);

		\dash\data::placeList($place_list);


	}
}
?>