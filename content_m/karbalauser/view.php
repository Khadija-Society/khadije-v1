<?php
namespace content_m\karbalauser;


class view
{
	public static function config()
	{
		\dash\permission::access('cpKarbalaUserCount');


		\dash\data::page_pictogram('atom');

		\dash\data::page_title("آمار زائران");

		$karbalauser = \lib\app\karbalasetting::stat();
		\dash\data::karbalauser($karbalauser);

		\dash\data::badge_link(\dash\url::this(). '/numbers');
		\dash\data::badge_text(T_('Setting'));

	}
}
?>
