<?php
namespace content_agent\send\edit;


class view extends \content_agent\send\add\view
{
	public static function config()
	{
		parent::config();

		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("ویرایش اطلاعات اعزام");

		\dash\data::page_pictogram('edit');


		$args_place = [];
		$args_place['pagenation'] = false;

		$place_list = \lib\app\agentplace::list(null, $args_place);

		\dash\data::placeList($place_list);




	}
}
?>