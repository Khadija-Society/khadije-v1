<?php
namespace content_lottery\item\permission;


class view
{
	public static function config()
	{
		\dash\data::page_title("Edit lottery access");
		\dash\data::page_desc(T_('Edit name or description of this item or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$id     = \dash\request::get('id');
		$result = \lib\app\syslottery::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid item id"));
		}

		\dash\data::dataRow($result);

		$who_have = \dash\permission::who_have('ContentLottery');
		if($who_have)
		{
			$who_have = implode("','", $who_have);
			$get_users = \dash\db\users::get(['permission' => ["IN", "('$who_have')"]]);
			$get_users = array_map(['\\dash\\app\\user', 'ready'], $get_users);
			\dash\data::whoHavePerm($get_users);
		}

		if(isset($result['permission']))
		{
			\dash\data::dataRow_permission(json_decode($result['permission'], true));
		}

	}
}
?>