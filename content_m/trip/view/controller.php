<?php
namespace content_m\trip\view;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpTripEdit');

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{

		}
		else
		{
			\dash\header::status(403, T_("Id not found"));
		}

		$travelDetail = \lib\db\travels::search(null, ['travels.id' => \dash\request::get('id'), 'pagenation' => false]);

		if(is_array($travelDetail))
		{
			$travelDetail = array_map(["self", "ready"], $travelDetail);
		}

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

	public static function ready($_data)
	{
		$_data = \dash\app::fix_avatar($_data);
		$result = [];
		$result['location_string'] = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{


				case 'country':
					$result[$key] = $value;
					$result['country_name'] = \dash\utility\location\countres::get_localname($value, true);
					$result['location_string'][1] = $result['country_name'];
					break;


				case 'province':
					$result[$key] = $value;
					$result['province_name'] = \dash\utility\location\provinces::get_localname($value);
					$result['location_string'][2] = $result['province_name'];
					break;

				case 'city':
					$result[$key] = $value;
					$result['city_name'] = \dash\utility\location\cites::get_localname($value);
					$result['location_string'][3] = $result['city_name'];
					break;


				default:
					$result[$key] = $value;
					break;
			}
		}
		ksort($result['location_string']);
		$result['location_string'] = array_filter($result['location_string']);
		$result['location_string'] = implode(T_("-"). " ", $result['location_string']);

		return $result;
	}
}
?>
