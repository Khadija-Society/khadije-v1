<?php
namespace content_protection\agentoccasion\users;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Registered user on this occasion"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$occasion_id = \dash\data::occasionID();

		$args = [];
		if(\dash\request::get('export'))
		{
			$args['pagination'] = false;
		}

		if(\dash\request::get('creator') && is_numeric(\dash\request::get('creator')))
		{
			$args['creator'] = \dash\request::get('creator');
		}

		$list = \lib\app\protectagentuser::admin_occasion_list($occasion_id, \dash\data::protectionAgentID(), $args);


		$countryList = \dash\utility\location\countres::$data;
		\dash\data::countryList($countryList);

		if(\dash\request::get('export'))
		{
			$new_list  = [];
			foreach ($list as $key => $value)
			{
				unset($value['location_string']);
				unset($value['id']);
				unset($value['protection_occasion_id']);
				unset($value['protection_user_id']);
				unset($value['protection_agent_id']);
				unset($value['status']);
				unset($value['desc']);
				unset($value['datemodified']);
				unset($value['user_id']);
				unset($value['postalcode']);
				unset($value['address']);
				unset($value['type_id']);
				unset($value['admindesc']);
				unset($value['birthday']);

				$new_list[] = $value;
			}

			\dash\utility\export::csv(['name' => 'export_protection_list_'. \dash\request::get('id'), 'data' => $new_list]);
		}
		\dash\data::userOccasionList($list);


		$occasionType = \lib\app\protectiontype::occasion_type($occasion_id);
		if(!is_array($occasionType))
		{
			$occasionType = [];
		}
		\dash\data::currentTypeID(array_column($occasionType, 'id'));
		\dash\data::occasionType($occasionType);


		$cityList    = \dash\utility\location\cites::$data;
		$proviceList = \dash\utility\location\provinces::key_list('localname');

		$new = [];
		foreach ($cityList as $key => $value)
		{
			$temp = '';

			if(isset($value['province']) && isset($proviceList[$value['province']]))
			{
				$temp .= $proviceList[$value['province']]. ' - ';
			}
			if(isset($value['localname']))
			{
				$temp .= $value['localname'];
			}
			$new[$key] = $temp;
		}
		asort($new);

		\dash\data::cityList($new);

	}

}
?>
