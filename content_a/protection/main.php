<?php
namespace content_a\protection;


class main
{
	public static function check()
	{
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
			else
			{
				\dash\header::status(403);
			}
		}


	}
}
?>
