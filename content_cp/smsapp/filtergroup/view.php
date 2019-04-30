<?php
namespace content_cp\smsapp\filtergroup;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		$args =
		[
			'pagenation' => false,
			'group_id'   => \dash\coding::decode(\dash\request::get('id')),
		];


		$dataTable = \lib\app\smsgroupfilter::list(null, $args);

		\dash\data::dataTable($dataTable);
	}
}
?>
