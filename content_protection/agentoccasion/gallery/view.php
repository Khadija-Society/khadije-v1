<?php
namespace content_protection\agentoccasion\gallery;


class view extends \content_a\protection\gallery\view
{
	public static function config()
	{
		parent::config();

		\dash\data::page_title(T_("Report image"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$gallery = \dash\data::dataRow_gallery();
		$gallery = json_decode($gallery, true);
		if(isset($gallery[0]) && count($gallery) === 1)
		{
			$gallery['gallery'] = $gallery;
		}
		\dash\data::dataTable($gallery);



	}

}
?>
