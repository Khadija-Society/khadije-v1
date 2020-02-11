<?php
namespace content_agent\servant\profiledetail;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('user');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of servants'));



		$countryList = \dash\utility\location\countres::$data;
		\dash\data::countryList($countryList);

		$cityList    = \dash\utility\location\cites::key_list('localname');
		\dash\data::cityList($cityList);

		$proviceList = \dash\utility\location\provinces::key_list('localname');
		\dash\data::proviceList($proviceList);

	}
}
?>