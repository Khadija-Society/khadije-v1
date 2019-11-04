<?php
namespace content_mokeb\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('ContentMokebOpen');

		$child = \dash\url::child();
		if($child)
		{
			$load_place = \lib\app\place::get($child);
			if($load_place)
			{
				$place_access = \dash\option::config('place_access');
				if($place_access)
				{
					if(is_array($place_access))
					{
						if(!in_array($child, $place_access))
						{
							\dash\header::status(403);
						}
					}
					elseif(is_string($place_access))
					{
						if($child != $place_access)
						{
							\dash\header::status(403);
						}
					}
				}
				\dash\data::mokebDetail($load_place);
				\dash\open::get();
				\dash\open::post();
			}
		}
		else
		{
			\dash\redirect::to(\dash\url::here());
		}

		if(!\dash\permission::supervisor())
		{

			$mokebDetail = \dash\data::mokebDetail();

			if(isset($mokebDetail['perm']) && is_array($mokebDetail['perm']) && $mokebDetail['perm'])
			{

				if(!in_array(\dash\coding::encode(\dash\user::id()), $mokebDetail['perm']))
				{
					\dash\header::status(403, 'شما دسترسی لازم را برای ثبت افراد در این موکب ندارید');
					return false;
				}
			}

		}
	}
}
?>