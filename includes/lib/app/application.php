<?php
namespace lib\app;

class application
{

	public static function detail_v6()
	{
		$detail             = [];
		$detail['version']  = self::version();
		$detail['homepage'] = self::homepage();
		return $detail;
	}


	private static function version()
	{
		$detail                     = [];
		$detail['last']             = 35;
		$detail['deprecated']       = 34;
		$detail['deprecated_title'] = T_("This version is deprecated");
		$detail['deprecated_desc']  = T_("To download new version of this app click blow link");
		$detail['update_title']     = T_("New version is released");
		$detail['update_desc']      = T_("To download new version of this app click blow link");

		return $detail;
	}


	private static function homepage()
	{
		$homepage              = [];
		$homepage[]            = self::karbala_signup_link();
		// $homepage[]            = self::link2_donate();
		$homepage[]            = self::linksServicesLine();
		$homepage[]            = self::linksWebsiteLine();
		$homepage[]            = self::salawat();
		$homepage[]            = self::inapplink('news', T_("News"));
		$homepage[]            = self::news();
		$homepage[]            = self::linksAboutLine();
		// $homepage[]            = self::hr();
		return $homepage;
	}


	private static function karbala_signup_link()
	{
		$link          = [];
		$link['type']  = 'banner';
		$link['image'] = \dash\url::static(). '/images/app/karbala201909.jpg';
		$link['url']   = \dash\url::kingdom(). '/karbala2';
		return $link;
	}


	private static function slider()
	{
		$link           = [];
		$link['type']   = 'slider';
		$posts          = \dash\app\posts::get_post_list(['special' => 'slider', 'limit' => 5]);
		$link['slider'] = $posts;
		return $link;
	}


	private static function news()
	{
		$link         = [];
		$link['type'] = 'news';
		$posts        = \dash\app\posts::get_post_list(['limit' => 3, 'language' => \dash\language::current()]);
		$link['news'] = $posts;
		return $link;
	}


	private static function hr()
	{
		$link          = [];
		$link['type']  = 'hr';
		return $link;
	}

	private static function inapplink($_link, $_title)
	{
		$link          = [];
		$link['type']  = 'inapplink';
		$link['title'] = $_title;
		$link['link']  = $_link;
		return $link;
	}


	private static function title($_title = null)
	{
		$link          = [];
		$link['type']  = 'title';
		$link['title'] = $_title ? $_title : T_("Hi!");
		return $link;
	}


	private static function link2_donate()
	{
		$link                     = [];
		$link['type']             = 'link2';

		$link['link'][0]['image'] = \dash\url::static(). '/images/app/donate-wide.jpg';
		$link['link'][0]['url']   = \dash\url::kingdom(). '/donate';
		$link['link'][0]['text']  = T_('Donate');

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/donateproduct-wide2.jpg';
		$link['link'][1]['url']   = \dash\url::kingdom(). '/donate/product';
		$link['link'][1]['text']  = T_('Donate Product Arbaeen');

		return $link;
	}



	private static function linksServicesLine()
	{
		$link                     = [];
		$link['type']             = 'link4';

		$link['link'][0]['image'] = \dash\url::static(). '/images/app/KhadijeBadge-deputy.png';
		$link['link'][0]['url']   = \dash\url::kingdom(). '/a/representation';
		$link['link'][0]['text']  = T_("Deputy pilgrimage");

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/KhadijeBadge-Encyclopedia.png';
		$link['link'][1]['url']   = \dash\url::kingdom().'/wiki';
		$link['link'][1]['text']  = T_("Encyclopedia");

		$link['link'][2]['image'] = \dash\url::static(). '/images/app/KhadijeBadge-travel.png';
		$link['link'][2]['url']   = \dash\url::kingdom(). '/a/group';
		$link['link'][2]['text']  = T_("Group travel");

		$link['link'][3]['image'] = \dash\url::static(). '/images/app/KhadijeBadge-consulting.png';
		$link['link'][3]['url']   = \dash\url::kingdom(). '/contact';
		$link['link'][3]['text']  = T_("Contact Us");

		return $link;
	}




	private static function linksWebsiteLine()
	{
		$link                     = [];
		$link['type']             = 'link4';

		$link['link'][0]['image'] = \dash\url::static(). '/images/app/LastLine-website.jpg';
		$link['link'][0]['url']   = \dash\url::kingdom();
		$link['link'][0]['type']  = 'browser';
		$link['link'][0]['text']  = T_("Website");

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/LastLine-services.jpg';
		$link['link'][1]['url']   = \dash\url::kingdom().'/a';
		$link['link'][1]['text']  = T_("Service Panel");

		$link['link'][2]['image'] = \dash\url::static(). '/images/app/LastLine-delneveshte.jpg';
		$link['link'][2]['url']   = 'delneveshte';
		$link['link'][2]['text']  = T_("Delneveshteha");

		$link['link'][3]['image'] = \dash\url::static(). '/images/app/LastLine-honors.jpg';
		$link['link'][3]['url']   = \dash\url::kingdom(). '/honors';
		$link['link'][3]['text']  = T_("Honors");

		return $link;
	}



	private static function linksAboutLine()
	{
		$link                     = [];
		$link['type']             = 'link4';

		$link['link'][0]['image'] = \dash\url::static(). '/images/app/KhadijeLine-about.jpg';
		$link['link'][0]['url']   = 'about';
		$link['link'][0]['text']   = T_("About");

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/KhadijeLine-mission.jpg';
		$link['link'][1]['url']   = 'mission';
		$link['link'][1]['text']   = T_("Mission");

		$link['link'][2]['image'] = \dash\url::static(). '/images/app/KhadijeLine-vision.jpg';
		$link['link'][2]['url']   = 'vision';
		$link['link'][2]['text']   = T_("Vision");

		$link['link'][3]['image'] = \dash\url::static(). '/images/app/KhadijeLine-language.jpg';
		$link['link'][3]['url']   = 'lang';
		$link['link'][3]['text']   = T_("Languages");

		return $link;
	}



	private static function titlelink_news()
	{
		$link          = [];
		$link['type']  = 'titlelink';
		$link['title']  = T_("News");
		$link['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['url']   = \dash\url::kingdom();
		return $link;
	}








	private static function link1()
	{
		$link          = [];
		$link['type']  = 'link1';
		$link['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['url']   = \dash\url::kingdom();
		return $link;
	}


	private static function link2()
	{
		$link                     = [];
		$link['type']             = 'link2';
		$link['link'][0]['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['link'][0]['url']   = \dash\url::kingdom();
		$link['link'][1]['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['link'][1]['url']   = \dash\url::kingdom();

		return $link;
	}


	private static function titlelink()
	{
		$link          = [];
		$link['type']  = 'titlelink';
		$link['title']  = T_("Your title");
		$link['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['url']   = \dash\url::kingdom();
		return $link;
	}


	private static function linkdesc()
	{
		$link          = [];
		$link['type']  = 'linkdesc';
		$link['title']  = T_("Your title");
		$link['desc']  = T_("Your desc");
		$link['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['url']   = \dash\url::kingdom();
		return $link;
	}



	private static function salawat()
	{
		$salawatCount         = \lib\db\salavats::shomar();
		$salawat              = [];
		$salawat['type']      = 'salawat';
		$salawat['count']     = $salawatCount;
		$salawat['fit_count'] = \dash\utility\human::fitNumber($salawatCount);
		return $salawat;
	}



}
?>