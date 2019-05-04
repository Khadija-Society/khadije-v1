<?php
namespace content_cp\smsapp\filtergroup;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		\dash\data::page_title(T_("Edit filter sms group"));
		\dash\data::page_desc(T_("You cat set some filter to group"));
		\dash\data::badge_link(\dash\url::this(). '/listgroup');
		\dash\data::badge_text(T_('Sms group list'));

		$args =
		[
			'pagenation' => false,
			'type'       => 'number',
			'group_id'   => \dash\coding::decode(\dash\request::get('id')),
		];


		$dataTable = \lib\app\smsgroupfilter::list(null, $args);

		\dash\data::dataTable($dataTable);
	}
}
?>