<?php
namespace content_a\group\verify;


class controller
{
	public static function routing()
	{
		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::kingdom(). '/enter');
			return;
		}


		$city = \dash\request::get('city');

		if(!$city)
		{
			\dash\header::status(403, T_("City not found"));
		}

		$term = \lib\app\travel::trip_get_terms('group', $city);

		if(!$term)
		{
			\dash\header::status(404);
		}

		\dash\data::termsAndCondition($term);

	}
}
?>
