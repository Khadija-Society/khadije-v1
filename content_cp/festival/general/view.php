<?php
namespace content_cp\festival\general;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('edit');

		\dash\data::display_festivalAdd('content_cp/festival/layout.html');

		\dash\data::page_title(\dash\data::dataRow_title(). ' | '. T_("Edit general setting"));
		\dash\data::page_desc(T_("Edit general setting of festival like title, slug and desctiption."));

		\dash\data::badge_link(\dash\url::here(). '/festival?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to festival dashboard'));

	}
}
?>
