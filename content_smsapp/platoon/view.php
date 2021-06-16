<?php
namespace content_smsapp\platoon;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('question');

		\dash\data::page_title(T_("Choose gateway mobile"));

		\dash\data::badge_link(\dash\url::kingdom());
		\dash\data::badge_text(T_('Exit'));


		$platoonList = \lib\app\platoon\tools::list();
		\dash\data::platoonList($platoonList);



	}
}
?>
