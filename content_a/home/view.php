<?php
namespace content_a\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Khadije Dashboard"));
		\dash\data::page_desc(\dash\data::site_desc());
		\dash\data::dateDetail(\dash\date::month_precent());

		if($load_festival = \lib\db\festivals::get(['status' => 'enable', 'limit' => 1]))
		{
			\dash\data::festivalEnable($load_festival);
		}


		if($load_protection_agent = \lib\db\protectionagent::get(['status' => 'enable', 'user_id' => \dash\user::id(), 'limit' => 1]))
		{
			\dash\data::enableProtection($load_protection_agent);
		}
		else
		{
			if($load_protection_agent = \lib\db\protectionagentoccasionchild::check_is_child(\dash\user::id()))
			{
				\dash\data::enableProtection($load_protection_agent);
				\dash\data::accessAsChild(true);
			}
		}

	}
}
?>
