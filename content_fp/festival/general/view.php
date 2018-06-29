<?php
namespace content_fp\festival\general;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('edit');

		\dash\data::display_festivalAdd('content_fp/festival/layout.html');

		\dash\data::page_title(T_("Edit festival"). ' '. \dash\data::dataRow_title());

		\dash\data::page_desc(T_("Edit festival and add some detail for this"));
		\dash\data::badge_link(\dash\url::here(). '/festival');
		\dash\data::badge_text(T_('Back to festival list'));

	}
}
?>
