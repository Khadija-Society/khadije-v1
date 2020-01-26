<?php
namespace content_m\find;


class view
{
	public static function config()
	{
		\dash\permission::access('cpNationalCodeView');

		\dash\data::page_pictogram('user-5');

		\dash\data::page_title(T_("Find"));

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));

		$q = \dash\request::get('q');
		if($q)
		{
			$data = \lib\app\find::q($q);
			\dash\data::myList($data);

		}
	}
}
?>
