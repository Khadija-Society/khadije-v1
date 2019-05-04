<?php
namespace content_m\familytrip\view;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpFamilyTripEdit');

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{

		}
		else
		{
			\dash\header::status(403, T_("Id not found"));
		}

		$travelDetail = \lib\db\travels::search(null, ['travels.id' => \dash\request::get('id'), 'pagenation' => false]);

		$in = [];

		if(\dash\permission::check('cpTripQom'))
		{
			array_push($in, 'qom');
		}

		if(\dash\permission::check('cpTripMashhad'))
		{
			array_push($in, 'mashhad');
		}

		if(\dash\permission::check('cpTripKarbala'))
		{
			array_push($in, 'karbala');
		}

		if(isset($travelDetail[0]['place']))
		{
			if(!in_array($travelDetail[0]['place'], $in))
			{
				\dash\header::status(403);
			}
		}
		else
		{
			\dash\header::status(403);
		}

		\dash\data::travelDetail($travelDetail);

		if(isset($travelDetail[0]))
		{
			\dash\data::travelDetail($travelDetail[0]);
		}

	}
}
?>
