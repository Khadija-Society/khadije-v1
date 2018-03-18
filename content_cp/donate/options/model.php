<?php
namespace content_cp\donate\options;


class model extends \addons\content_cp\main\model
{

	public function post_donate()
	{
		if(\lib\request::post('type') === 'delete' && \lib\request::post('key'))
		{
			if(\lib\app\donate::remove_way(\lib\request::post('key')))
			{
				\lib\notif::warn(T_("The way successfully removed"));
			}
			else
			{
				return;
			}
		}
		else
		{
			$way = \lib\request::post('way');

			\lib\app\donate::set_way($way);

			\lib\notif::ok(T_("Way successfully added"));
		}

		if(\lib\notif::$status)
		{
			\lib\redirect::pwd();
		}
	}
}
?>
