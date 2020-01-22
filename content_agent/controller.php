<?php
namespace content_agent;


class controller
{
	public static function routing()
	{

		\dash\permission::access('contentAgent');

		$allow_city = [];

		if(\dash\permission::check('AgentQom'))
		{
			$allow_city[] = 'qom';
		}

		if(\dash\permission::check('AgentMashhad'))
		{
			$allow_city[] = 'mashhad';
		}

		if(\dash\permission::check('AgentKarbala'))
		{
			$allow_city[] = 'karbala';
		}

		if(count($allow_city) === 1)
		{
			\dash\data::oneCity(true);
			$xCity = $allow_city[0];
		}
		else
		{
			$xCity = \dash\request::get('city');
		}

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


		if(!in_array($xCity, $allow_city))
		{
			\dash\header::status(403, 'شما دسترسی لازم برای مدیریت این شهر را ندارید');
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
