<?php
namespace content_smsapp;

class controller
{
	public static function routing()
	{
		$allow_mobile =
		[
			'989127522690', // ?
			'989126788630', // ?
			'989129382128', // najafi
		];

		if(\dash\permission::supervisor() || in_array(\dash\user::detail('mobile'), $allow_mobile))
		{
			\dash\permission::access('smsAppSetting');
			// nothing
		}
		else
		{
			\dash\redirect::to(\dash\url::kingdom(). '/enter?referer='. \dash\url::pwd());
		}

		if(!\dash\permission::supervisor())
		{
			\dash\data::doNotTuch(true);
		}


		\lib\app\platoon\tools::lock(\dash\request::get('platoon'));

		if(!\lib\app\platoon\tools::get_index_locked())
		{
			if(\dash\url::module() !== 'platoon')
			{
				\dash\redirect::to(\dash\url::here(). '/platoon');
			}
		}

		$platoonCurrentDetail = \lib\app\platoon\tools::get_current_detail();
		\dash\data::platoonCurrentDetail($platoonCurrentDetail);

		\dash\data::platoonGet('?platoon='. \dash\request::get('platoon'));
		\dash\data::platoonGetAnd('&platoon='. \dash\request::get('platoon'));
		\dash\data::platoonGetJson(',"platoon":"'. \dash\request::get('platoon').'"');
	}


	public static function do_not_tuch($_return = false)
	{
		if(!\dash\permission::supervisor())
		{
			// \dash\redirect::to(\dash\url::here(). '/answergroup?id=p');
		}
	}


}
?>