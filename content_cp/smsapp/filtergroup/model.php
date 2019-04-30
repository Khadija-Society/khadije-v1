<?php
namespace content_cp\smsapp\filtergroup;


class model
{
	public static function post()
	{
		if(\dash\request::post('type') === 'remove')
		{
			if(\lib\app\smsgroupfilter::remove(\dash\request::post('deleteid')))
			{
				\dash\notif::ok(T_("Filter removed"));
				\dash\redirect::pwd();
			}
			return;
		}

		$post            = [];
		$post['number']   = \dash\request::post('number');
		$post['group_id']    = \dash\request::get('id');

		$result = \lib\app\smsgroupfilter::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
