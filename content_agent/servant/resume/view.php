<?php
namespace content_agent\servant\resume;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("ثبت و نمایش رزومه خادم");

		\dash\data::page_pictogram('magic');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of servants'));


		$userid = \dash\coding::decode(\dash\request::get('user'));
		if($userid)
		{
			\dash\data::dataTable(\lib\app\resume::list(null,['user_id' => $userid, 'pagenation' => false]));
		}


		if(\dash\request::get('id'))
		{
			$detail = \lib\app\resume::get(\dash\request::get('id'));
			\dash\data::dataRow($detail);
		}

	}
}
?>