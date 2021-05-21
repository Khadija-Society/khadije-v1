<?php
namespace content_smsapp\conversation\view;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('chat');

		\dash\data::page_title(T_("Conversation"));

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));


		$filterArray = [];
		$countArgs   = [];

		$args =
		[
			'order'      => \dash\request::get('order'),
			'sort'       => \dash\request::get('sort'),
			'limit'      => 100,
			'fromnumber' => \dash\data::myMobile(),
		];

		$q = \dash\request::get('q');

		$list = \lib\app\conversation\search::view($q, $args);

		\dash\data::dataTable($list);

	}
}
?>
