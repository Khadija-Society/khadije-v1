<?php
namespace content_m\doyon\view;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpDoyonView');

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{

		}
		else
		{
			\dash\header::status(403, T_("Id not found"));
		}

		$doyonDetail = \lib\db\doyon::search(null, ['doyon.id' => \dash\request::get('id')]);

		\dash\data::doyon($doyonDetail);

		if(isset($doyonDetail[0]))
		{
			\dash\data::doyonDetail($doyonDetail[0]);
		}
		else
		{
			\dash\header::status(404, T_("Invalid id"));
		}

	}
}
?>
