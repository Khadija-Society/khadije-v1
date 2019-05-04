<?php
namespace content_m\consulting\view;


class controller
{
	public static function routing()
	{
		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{

		}
		else
		{
			\dash\header::status(403, T_("Id not found"));
		}

		$travelDetail = \lib\db\services::search(null, ['services.id' => \dash\request::get('id')]);

		\dash\data::serviceDetail($travelDetail);

		if(isset($travelDetail[0]))
		{
			\dash\data::serviceDetail($travelDetail[0]);
		}
		else
		{
			\dash\header::status(404, T_("Invalid id"));
		}
	}
}
?>
