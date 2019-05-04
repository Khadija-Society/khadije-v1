<?php
namespace content_m\home;

class view
{
	public static function config()
	{
		\dash\permission::access('contentCp');
		\dash\data::page_pictogram('gauge');


		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::display_cp_posts("content_m/posts/layout.html");
		\dash\data::display_cpSample("content_m/sample/layout.html");


		\dash\data::dash_version(\dash\engine\version::get());
		\dash\data::dash_lastUpdate(\dash\utility\git::getLastUpdate());

		\dash\data::page_title(T_(ucfirst( str_replace('/', ' ', \dash\url::directory()))));

		if(!\dash\data::page_title())
		{
			\dash\data::page_title(T_("Khadije Dashboard"));
		}
		\dash\data::page_desc(T_("Khadije Dashboard"));

		// $this->data->dir['right']     = $this->global->direction == 'rtl'? 'left':  'right';
		// $this->data->dir['left']      = $this->global->direction == 'rtl'? 'right': 'left';
	}
}
?>
