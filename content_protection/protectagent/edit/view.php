<?php
namespace content_protection\protectagent\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit protect agent"));
		\dash\data::page_desc(T_('Edit name or description of this protect agent or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());

		\dash\data::badge_text(T_('Back to list of protect agent'));


		$agentType = \lib\app\protectiontype::get_all('agenttype');
		\dash\data::agentType($agentType);


		$id     = \dash\request::get('id');
		$result = \lib\app\protectagent::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid protectagent id"));
		}

		if(isset($result['user_id']) && $result['user_id'])
		{
			$load_detail = \dash\db\users::get_by_id($result['user_id']);
			if(isset($load_detail['mobile']))
			{
				$result['mobile'] = $load_detail['mobile'];
			}
		}
		\dash\data::dataRow($result);


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