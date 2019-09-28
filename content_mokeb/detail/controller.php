<?php
namespace content_mokeb\detail;


class controller
{
	public static function routing()
	{
		$nationalcode = \dash\request::get('nationalcode');
		if($nationalcode && \dash\utility\filter::nationalcode($nationalcode))
		{
			$loadUser = \lib\db\mokebusers::get(['nationalcode' => $nationalcode, 'limit' => 1]);
			if($loadUser)
			{
				\dash\data::mokebuserDetail($loadUser);
				\dash\open::get();
				\dash\open::post();
			}
		}
		else
		{
			\dash\redirect::to(\dash\url::here());
		}
	}
}
?>