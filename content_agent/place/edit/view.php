<?php
namespace content_agent\place\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title("ویرایش اطلاعات زائرسرا");
		\dash\data::page_desc(T_('Edit name or description of this place or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to list of Places'));

		$id     = \dash\request::get('id');
		$result = \lib\app\agentplace::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid place id"));
		}

		\dash\data::dataRow($result);


		$servant_args = ['pagenation' => false];
		$city = \dash\data::dataRow_city();

		if($city)
		{
			$servant_args['agent_servant.city'] = $city;
		}

		$adminOfficeList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'adminoffice']));

		\dash\data::adminOfficeList($adminOfficeList);


		$servantList = \lib\app\servant::list(null, array_merge($servant_args, ['agent_servant.job' => 'servant']));

		\dash\data::servantList($servantList);


	}
}
?>