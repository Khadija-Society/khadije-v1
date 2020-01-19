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


		if(\dash\data::dataRow_place_id())
		{
			$default_place = \lib\app\agentplace::get(\dash\data::dataRow_place_id());
			\dash\data::defaultPlace($default_place);

		}


		$args_place = [];
		$args_place['pagenation'] = false;

		$place_list = \lib\app\agentplace::list(null, $args_place);

		\dash\data::placeList($place_list);




	}
}
?>