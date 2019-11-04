<?php
namespace content_mokeb\place\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit place"));
		\dash\data::page_desc(T_('Edit name or description of this place or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to list of Places'));

		$id     = \dash\request::get('id');
		$result = \lib\app\place::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid place id"));
		}

		\dash\data::dataRow($result);

		$who_have = \dash\permission::who_have('ContentMokebAddUser');
		if($who_have)
		{
			$who_have = implode("','", $who_have);
			$get_users = \dash\db\users::get(['permission' => ["IN", "('$who_have')"]]);
			$get_users = array_map(['\\dash\\app\\user', 'ready'], $get_users);
			\dash\data::whoHavePerm($get_users);
		}

	}
}
?>