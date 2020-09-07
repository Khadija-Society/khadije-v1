<?php
namespace content_protection\agenttype;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonSetting');
		$id = \dash\request::get('id');
		if($id)
		{
			$load_detail = \lib\app\protectiontype::get($id);
			if(!$load_detail)
			{
				\dash\header::status(404);
			}
			\dash\data::editMode(true);
			\dash\data::dataRow($load_detail);
		}
	}
}
?>