<?php
namespace content_protection\agentoccasion\users;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Register user"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$occasion_id = \dash\data::occasionID();

		$list = \lib\app\protectagentuser::admin_occasion_list($occasion_id);
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
