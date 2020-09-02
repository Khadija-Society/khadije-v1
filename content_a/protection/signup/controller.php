<?php
namespace content_a\protection\signup;


class controller
{
	public static function routing()
	{
		\content_a\protection\main::check();


		$id = \dash\request::get('id');
		if($id)
		{
			$load = \lib\app\occasion::get($id);
			if(!$load)
			{
				\dash\header::status(404);
			}

			if(isset($load['status']) && in_array($load['status'], ['registring', 'distribution']))
			{
				// ok
			}
			else
			{
				\dash\header::status(403, T_("This occasion is not enable"));
			}

			\dash\data::occasionDetail($load);
			\dash\data::dataDetail(\lib\app\occasion::get_detail(\dash\request::get('id')));
		}
	}
}
?>