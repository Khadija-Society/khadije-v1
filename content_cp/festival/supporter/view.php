<?php
namespace content_cp\festival\supporter;


class view
{
	public static function config()
	{
		\dash\data::display_festivalSupporterDisplay('content_cp/festival/supporter/list.html');

		\dash\data::badge_link(\dash\url::this(). '/supporter?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to supporter list'));

		if(\dash\request::get('type') === 'add')
		{
			\dash\permission::access('festivalSupporterAdd');
			\dash\data::display_festivalSupporterDisplay('content_cp/festival/supporter/add.html');
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Add new supporter"));
			\dash\data::page_desc(T_("Add new supporter by some detail"));
			\dash\data::page_pictogram('plus');

		}
		elseif(\dash\request::get('supporter'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('supporter'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Edit supporter"));

			\dash\permission::access('festivalSupporterAdd');

			\dash\data::display_festivalSupporterDisplay('content_cp/festival/supporter/add.html');

			\dash\data::page_desc(T_("Edit supporter"). '| '. \dash\data::dataRow_title());
			\dash\data::page_pictogram('edit');

		}
		else
		{
			\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
			\dash\data::badge_text(T_('Back to dashboard'));

			\dash\permission::access('fpFestivalView');

			\dash\data::page_pictogram('crosshairs');

			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Supporter list"));

			\dash\data::page_desc(T_("check festival supporter and add or edit a supporter"));

			$args                = [];
			$args['order']       = 'DESC';
			$args['festival_id'] = \dash\coding::decode(\dash\request::get('id'));
			$args['type']        = 'supporter';
			$args['pagenation']  = false;

			$dataTable = \lib\app\festivaldetail::list(null, $args);

			\dash\data::dataTable($dataTable);
		}
	}

}
?>
