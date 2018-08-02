<?php
namespace content_cp\festival\message;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('edit');

		\dash\data::display_festivalAdd('content_cp/festival/layout.html');

		\dash\data::page_title(\dash\data::dataRow_title(). ' | '. T_("Edit festival message"));

		\dash\data::page_desc(T_("This message will be show when the user signup to a festival course"));
		\dash\data::badge_link(\dash\url::here(). '/festival?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to festival dashboard'));

	}
}
?>
