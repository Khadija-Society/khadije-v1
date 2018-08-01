<?php
namespace content_cp\referee;


class load
{
	public static function festival()
	{
		$id   = \dash\request::get('id');
		$load = \lib\app\festival::get($id);

		if($load)
		{
			\dash\data::currentFestival($load);
			return $load;
		}

		\dash\header::status(404, T_("Id not found"));
	}
}
?>
