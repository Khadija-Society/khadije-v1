<?php
namespace content_a\protection\gallery;


class view
{
	public static function config()
	{


		\dash\data::mediaTitle(\lib\app\protectionagentoccasion::field_list());

		\dash\data::page_title(T_("Report image"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$gallery = \dash\data::dataRow();

		foreach ($gallery as $key => $value)
		{
			switch ($key)
			{
				case 'gallery':
				case 'film':
				case 'simanews':
				case 'clip':
				case 'newsinwebsite':
				case 'videodistribution':
					$gallery[$key] = json_decode($value,  true);
					break;

				default:
					break;
			}
		}

		\dash\data::dataTable($gallery);


	}

}
?>