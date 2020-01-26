<?php
namespace content_agent\send\view;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("نمایش جزئیات اعزام");

		\dash\data::page_pictogram('paper-plane');

		\content_agent\send\billing\view::tempText();

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));


		$myUsers =
		[
			'clergy'      => ['title' => "روحانی کاروان"],
			'admin'       => ['title' => "مدیر کاروان"],
			'adminoffice' => ['title' => "مدیر زائر سرا"],
			'missionary'  => ['title' => "مبلغ"],
			'servant'     => ['title' => "نگهبان"],
			'servant2'     => ['title' => "نگهبان ۲"],
			'maddah'      => ['title' => "مداح"],
			'rabet'      => ['title' => "رابط"],
			'nazer'       => ['title' => "ناظر"],
			'khadem'      => ['title' => "خادم"],
			'khadem2'     => ['title' => "خادم ۲"],

		];
		\dash\data::myUsers($myUsers);


	}
}
?>