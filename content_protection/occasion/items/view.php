<?php
namespace content_protection\occasion\items;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit occasion"));
		\dash\data::page_desc(T_('Edit name or description of this occasion or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());

		\dash\data::badge_text(T_('Back to list of occasion'));

		$id     = \dash\request::get('id');
		$result = \lib\app\occasion::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid occasion id"));
		}

		\dash\data::dataRow($result);

		\dash\data::dataDetail(\lib\app\occasion::get_detail(\dash\request::get('id')));

		$typeList = \lib\app\protectiontype::get_all();
		\dash\data::typeList($typeList);

		$occasionTypeList = \lib\app\protectiontype::get_all('occasiontype');
		\dash\data::occasionTypeList($occasionTypeList);

		$occasionType = \lib\app\protectiontype::occasion_type(\dash\request::get('id'));
		if(!is_array($occasionType))
		{
			$occasionType = [];
		}
		\dash\data::currentTypeID(array_column($occasionType, 'id'));
		\dash\data::occasionType($occasionType);


	}
}
?>