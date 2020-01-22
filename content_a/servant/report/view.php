<?php
namespace content_a\servant\report;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("گزارش تصویری");

		\dash\data::page_pictogram('picture');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));

		$send_id = \dash\coding::decode(\dash\request::get('id'));
		if($send_id)
		{
			$data = \lib\db\agentfile::get(['send_id' => $send_id, 'creator' => \dash\user::id()]);
			if($data)
			{
				$data = array_map(['\\dash\\app', 'ready'], $data);
			}

			\dash\data::dataTable($data);
		}


	}


}
?>