<?php
namespace content_fp\home;

class view
{
	public static function config()
	{
		\dash\permission::access('contentFp');
		\dash\data::page_pictogram('magic');

		\dash\data::dash_version(\dash\engine\version::get());
		\dash\data::dash_lastUpdate(\dash\utility\git::getLastUpdate());

		\dash\data::page_title(T_(ucfirst( str_replace('/', ' ', \dash\url::directory()))));

		if(!\dash\data::page_title())
		{
			\dash\data::page_title(T_("Khadije Festival Dashboard"));
		}
		\dash\data::page_desc(T_("Khadije Festival Dashboard"));

		// $this->data->dir['right']     = $this->global->direction == 'rtl'? 'left':  'right';
		// $this->data->dir['left']      = $this->global->direction == 'rtl'? 'right': 'left';

		$all_festival = \lib\db\festivals::get(['status' => [" IS ", " NOT NULL"]]);
		\dash\data::festivals(array_map(['\lib\app\festival', 'ready'], $all_festival));
	}
}
?>
