<?php
namespace content_lottery;


class controller
{
	public static function routing()
	{

		\dash\permission::access('contentAgent');

		$allow_type = [];

		if(\dash\permission::check('AgentQom'))
		{
			$allow_type[] = 'qom';
		}

		if(\dash\permission::check('AgentMashhad'))
		{
			$allow_type[] = 'mashhad';
		}

		if(\dash\permission::check('AgentKarbala'))
		{
			$allow_type[] = 'karbala';
		}

		if(count($allow_type) === 1)
		{
			\dash\data::oneType(true);
			$xType = $allow_type[0];
		}
		else
		{
			$xType = \dash\request::get('type');
		}

		if(!$xType)
		{
			if(\dash\url::module() === 'type')
			{
				return;
				// too many redirect!
			}
			else
			{
				// \dash\redirect::to(\dash\url::here(). '/type');
			}
		}


		if(!in_array($xType, $allow_type))
		{
			// \dash\header::status(403, 'شما دسترسی لازم برای مدیریت این شهر را ندارید');
		}


		$get = \dash\request::get();
		unset($get['type']);

		if($get)
		{
			$start = '&';
		}
		else
		{
			$start = '?';
		}

		\dash\data::xType($start. 'type='. $xType);
		\dash\data::xTypeStart('?type='. $xType);
		\dash\data::xTypeAnd('&type='. $xType);

		\dash\data::xTypeTitle(T_($xType));
		\dash\data::xTypeTitlePage(' | '. \dash\data::xTypeTitle());
	}
}
?>
