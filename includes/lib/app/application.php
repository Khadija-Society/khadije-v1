<?php
namespace lib\app;

class application
{

	public static function detail_v6()
	{
		$homepage              = [];
		$homepage[]            = self::link1();
		$homepage[]            = self::link2();
		$homepage[]            = self::hr();
		$homepage[]            = self::link4();
		$homepage[]            = self::titlelink();
		$homepage[]            = self::link1();
		$homepage[]            = self::title();
		$homepage[]            = self::hr();
		$homepage[]            = self::slider();
		$homepage[]            = self::linkdesc();
		$homepage[]            = self::salawat();
		$homepage[]            = self::hr();
		$homepage[]            = self::news();
		$homepage[]            = self::hr();

		return ['homepage' => $homepage];
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


	private static function link4()
	{
		$link                     = [];

		$link['type']             = 'link4';

		$link['link'][0]['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['link'][0]['url']   = \dash\url::kingdom();

		$link['link'][1]['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['link'][1]['url']   = \dash\url::kingdom();

		$link['link'][2]['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['link'][2]['url']   = \dash\url::kingdom();

		$link['link'][3]['image'] = \dash\url::site(). '/static/images/logo.png';
		$link['link'][3]['url']   = \dash\url::kingdom();

		return $link;
	}


	private static function slider()
	{
		$link                     = [];

		$link['type']             = 'slider';

		$link['slider'][0]['title']   = T_("News title");
		$link['slider'][0]['content'] = T_("News content");
		$link['slider'][0]['image']   = \dash\url::site(). '/static/images/logo.png';
		$link['slider'][0]['url']     = \dash\url::kingdom();

		$link['slider'][1]['title']   = T_("News title");
		$link['slider'][1]['content'] = T_("News content");
		$link['slider'][1]['image']   = \dash\url::site(). '/static/images/logo.png';
		$link['slider'][1]['url']     = \dash\url::kingdom();


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


	private static function title()
	{
		$link          = [];
		$link['type']  = 'title';
		$link['title']  = T_("Your static title");
		return $link;
	}


	private static function salawat()
	{
		$link          = [];
		$link['type']  = 'salawat';
		$link['count'] = 46546454;
		return $link;
	}

	private static function hr()
	{
		$link          = [];
		$link['type']  = 'hr';
		return $link;
	}

	private static function news()
	{
		$link                     = [];

		$link['type']             = 'news';

		$link['news'][0]['title']   = T_("News title");
		$link['news'][0]['content'] = T_("News content");
		$link['news'][0]['image']   = \dash\url::site(). '/static/images/logo.png';
		$link['news'][0]['url']     = \dash\url::kingdom();

		$link['news'][1]['title']   = T_("News title");
		$link['news'][1]['content'] = T_("News content");
		$link['news'][1]['image']   = \dash\url::site(). '/static/images/logo.png';
		$link['news'][1]['url']     = \dash\url::kingdom();


		return $link;
	}
}
?>