<?php
namespace content_lottery\item\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title("ویرایش اطلاعات زائرسرا");
		\dash\data::page_desc(T_('Edit name or description of this item or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xTypeStart());
		\dash\data::badge_text(T_('Back to list of Places'));

		$id     = \dash\request::get('id');
		$result = \lib\app\agentitem::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid item id"));
		}

		\dash\data::dataRow($result);


		$servant_args = ['pagenation' => false];
		$type = \dash\data::dataRow_type();

		if($type)
		{
			$servant_args['agent_servant.type'] = $type;
		}

		$adminOfficeList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'adminoffice']));

		\dash\data::adminOfficeList($adminOfficeList);


		$servantList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'servant']));

		\dash\data::servantList($servantList);


	}
}
?>