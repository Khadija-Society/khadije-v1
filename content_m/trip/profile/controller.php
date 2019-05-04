<?php
namespace content_m\trip\profile;


class controller
{
	public static function routing()
	{
		$userdetail = \dash\db\users::get(['id' => \dash\coding::decode(\dash\request::get('user')), 'limit' => 1]);
		if(!$userdetail)
		{
			\dash\header::status(404);
		}
		\dash\data::userdetail($userdetail);
	}
}
?>
