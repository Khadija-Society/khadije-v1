<?php
namespace content_agent;


class controller
{
	public static function routing()
	{
		\dash\permission::access('contentAgent');

		$xCity = \dash\request::get('city');
		if(!$xCity)
		{
			if(\dash\url::module() === 'city')
			{
				return;
				// too many redirect!
			}
			else
			{
				\dash\redirect::to(\dash\url::here(). '/city');
			}
		}

		if(!in_array($xCity, ['qom', 'mashhad', 'karbala']))
		{
			\dash\header::status(400, 'City');
		}

		$get = \dash\request::get();
		unset($get['city']);

		if($get)
		{
			$start = '&';
		}
		else
		{
			$start = '?';
		}

		\dash\data::xCity($start. 'city='. $xCity);
		\dash\data::xCityStart('?city='. $xCity);
		\dash\data::xCityAnd('&city='. $xCity);

		\dash\data::xCityTitle(T_($xCity));
		\dash\data::xCityTitlePage(' | '. \dash\data::xCityTitle());
	}
}
?>
