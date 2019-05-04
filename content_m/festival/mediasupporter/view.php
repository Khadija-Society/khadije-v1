<?php
namespace content_m\festival\mediasupporter;


class view
{
	public static function config()
	{
		\dash\data::display_festivalMediasupporterDisplay('content_m/festival/mediasupporter/list.html');

		\dash\data::badge_link(\dash\url::this(). '/mediasupporter?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to mediasupporter list'));

		if(\dash\request::get('type') === 'add')
		{
			\dash\permission::access('cpFestivalMediasupporterAdd');
			\dash\data::display_festivalMediasupporterDisplay('content_m/festival/mediasupporter/add.html');
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Add new mediasupporter"));
			\dash\data::page_desc(T_("Add new mediasupporter by some detail"));
			\dash\data::page_pictogram('plus');

		}
		elseif(\dash\request::get('mediasupporter'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('mediasupporter'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Edit mediasupporter"));

			\dash\permission::access('cpFestivalMediasupporterEdit');

			\dash\data::display_festivalMediasupporterDisplay('content_m/festival/mediasupporter/add.html');

			\dash\data::page_desc(T_("Edit mediasupporter"). '| '. \dash\data::dataRow_title());
			\dash\data::page_pictogram('edit');

		}
		else
		{
			\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
			\dash\data::badge_text(T_('Back to dashboard'));

			\dash\permission::access('cpFestivalMediasupporterView');

			\dash\data::page_pictogram('bullhorn');

			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Mediasupporter list"));

			\dash\data::page_desc(T_("check festival mediasupporter and add or edit a mediasupporter"));

			$args                = [];
			$args['order']       = 'DESC';
			$args['festival_id'] = \dash\coding::decode(\dash\request::get('id'));
			$args['type']        = 'mediasupporter';
			$args['pagenation']  = false;

			$dataTable = \lib\app\festivaldetail::list(null, $args);

			\dash\data::dataTable($dataTable);
		}
	}

}
?>
