<?php
namespace content_cp\festival\referee;


class view
{
	public static function config()
	{
		\dash\data::display_festivalRefereeDisplay('content_cp/festival/referee/list.html');

		\dash\data::badge_link(\dash\url::this(). '/referee?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to referee list'));

		if(\dash\request::get('type') === 'add')
		{
			\dash\permission::access('festivalRefereeAdd');
			\dash\data::display_festivalRefereeDisplay('content_cp/festival/referee/add.html');
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Add new referee"));
			\dash\data::page_desc(T_("Add new referee by some detail"));
			\dash\data::page_pictogram('plus');

		}
		elseif(\dash\request::get('referee'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('referee'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Edit referee"));

			\dash\permission::access('festivalRefereeAdd');

			\dash\data::display_festivalRefereeDisplay('content_cp/festival/referee/add.html');

			\dash\data::page_desc(T_("Edit referee"). '| '. \dash\data::dataRow_title());
			\dash\data::page_pictogram('edit');

		}
		else
		{
			\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
			\dash\data::badge_text(T_('Back to dashboard'));

			\dash\permission::access('fpFestivalView');

			\dash\data::page_pictogram('plug');

			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Referee list"));

			\dash\data::page_desc(T_("check festival referee and add or edit a referee"));

			$args                = [];
			$args['order']       = 'DESC';
			$args['festival_id'] = \dash\coding::decode(\dash\request::get('id'));
			$args['type']        = 'referee';
			$args['pagenation']  = false;

			$dataTable = \lib\app\festivaldetail::list(null, $args);

			\dash\data::dataTable($dataTable);
		}
	}

}
?>
