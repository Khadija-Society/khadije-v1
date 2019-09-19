<?php
namespace lib\app;

class application
{

	public static function detail_v6()
	{
		$detail             = [];
		$detail['homepage'] = self::homepage();

		return $detail;
	}


	private static function homepage()
	{
		$homepage              = [];
		$homepage[]            = self::karbala_signup_link();
		$homepage[]            = self::link2_donate();
		$homepage[]            = self::inapplink('news', T_("News"));
		$homepage[]            = self::link4();
		$homepage[]            = self::hr();
		$homepage[]            = self::salawat();
		return $homepage;
	}


	private static function karbala_signup_link()
	{
		$link          = [];
		$link['type']  = 'link1';
		$link['image'] = 'https://khadije.com/files/1/503-b42df374abb06a9226db84212a3f3b5a.jpg';
		$link['url']   = \dash\url::kingdom(). '/app/karbala2';
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
		$posts        = \dash\app\posts::get_post_list(['limit' => 10]);
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

		$link['link'][0]['image'] = 'https://khadije.com/static/siftal/images/useful/care.png';
		$link['link'][0]['url']   = \dash\url::kingdom(). '/app/donate';

		$link['link'][1]['image'] = 'https://khadije.com/static/siftal/images/useful/care.png';
		$link['link'][1]['url']   = \dash\url::kingdom(). '/donate/product';

		return $link;
	}


	private static function link4()
	{
		$link                     = [];
		$link['type']             = 'link4';

		$link['link'][0]['image'] = 'https://khadije.com/static/siftal/images/useful/care.png';
		$link['link'][0]['url']   = 'about';

		$link['link'][1]['image'] = 'https://khadije.com/static/siftal/images/useful/care.png';
		$link['link'][1]['url']   = 'mission';

		$link['link'][2]['image'] = 'https://khadije.com/static/siftal/images/useful/care.png';
		$link['link'][2]['url']   = 'vision';

		$link['link'][3]['image'] = 'https://khadije.com/static/siftal/images/useful/care.png';
		$link['link'][3]['url']   = 'lang';

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