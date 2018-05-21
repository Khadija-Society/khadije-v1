<?php
namespace content_cp\delneveshte\edit;

class view
{
	public static function config()
	{

		$id = \dash\request::get('id');

		$detail = \dash\app\comment::get($id);
		if(!$detail)
		{
			\dash\header::status(403, T_("Invalid id"));
		}

		\dash\data::dataRow($detail);
		// $this->data->cat_list              = \dash\app\term::cat_list();

		\dash\data::page_title(T_("Edit delneveshte"));
		\dash\data::page_desc(T_("You can accept or reject the delneveshte"));

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to list of delneveshte'));

	}
}
?>