<?php
namespace content_cp\festival\organizer;


class view
{
	public static function config()
	{
		\dash\data::display_festivalOrganizerDisplay('content_cp/festival/organizer/list.html');

		\dash\data::badge_link(\dash\url::this(). '/organizer?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to organizer list'));

		if(\dash\request::get('type') === 'add')
		{
			\dash\permission::access('cpFestivalOrganizerAdd');
			\dash\data::display_festivalOrganizerDisplay('content_cp/festival/organizer/add.html');
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Add new organizer"));
			\dash\data::page_desc(T_("Add new organizer by some detail"));
			\dash\data::page_pictogram('plus');

		}
		elseif(\dash\request::get('organizer'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('organizer'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Edit organizer"));

			\dash\permission::access('cpFestivalOrganizerEdit');

			\dash\data::display_festivalOrganizerDisplay('content_cp/festival/organizer/add.html');

			\dash\data::page_desc(T_("Edit organizer"). '| '. \dash\data::dataRow_title());
			\dash\data::page_pictogram('edit');

		}
		else
		{
			\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
			\dash\data::badge_text(T_('Back to dashboard'));

			\dash\permission::access('cpFestivalOrganizerView');

			\dash\data::page_pictogram('plug');

			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Organizer list"));

			\dash\data::page_desc(T_("check festival organizer and add or edit a organizer"));

			$args                = [];
			$args['order']       = 'DESC';
			$args['festival_id'] = \dash\coding::decode(\dash\request::get('id'));
			$args['type']        = 'organizer';
			$args['pagenation']  = false;

			$dataTable = \lib\app\festivaldetail::list(null, $args);

			\dash\data::dataTable($dataTable);
		}
	}

}
?>
