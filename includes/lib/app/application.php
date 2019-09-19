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
		// $homepage[]            = self::slider();
		// $homepage[]            = self::hr();
		$homepage[]            = self::link2_donate();
		$homepage[]            = self::title(T_("News"));
		$homepage[]            = self::news();
		$homepage[]            = self::hr();
		$homepage[]            = self::salawat();


		// $homepage[]            = self::link2();
		// $homepage[]            = self::link1();
		// $homepage[]            = self::title();
		// $homepage[]            = self::hr();
		// $homepage[]            = self::linkdesc();
		// $homepage[]            = self::hr();
		// $homepage[]            = self::hr();

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
		$link            = [];

		$link['type']    = 'slider';
		$posts           = \dash\app\posts::get_post_list(['special' => 'slider', 'limit' => 5]);
		$link['slider'] = $posts;

		// // special slider limit 5
		// $link['slider'][0]['title']   = T_("News title");
		// $link['slider'][0]['content'] = T_("News content");
		// $link['slider'][0]['image']   = \dash\url::site(). '/static/images/logo.png';
		// $link['slider'][0]['url']     = \dash\url::kingdom();

		// $link['slider'][1]['title']   = T_("News title");
		// $link['slider'][1]['content'] = T_("News content");
		// $link['slider'][1]['image']   = \dash\url::site(). '/static/images/logo.png';
		// $link['slider'][1]['url']     = \dash\url::kingdom();


		return $link;
	}


	private static function news()
	{
		$link         = [];

		$link['type'] = 'news';
		$posts        = \dash\app\posts::get_post_list(['limit' => 10]);
		$link['news'] = $posts;

		// $link['news'][0]['title']   = T_("News title");
		// $link['news'][0]['content'] = T_("News content");
		// $link['news'][0]['image']   = \dash\url::site(). '/static/images/logo.png';
		// $link['news'][0]['url']     = \dash\url::kingdom();

		// $link['news'][1]['title']   = T_("News title");
		// $link['news'][1]['content'] = T_("News content");
		// $link['news'][1]['image']   = \dash\url::site(). '/static/images/logo.png';
		// $link['news'][1]['url']     = \dash\url::kingdom();


		return $link;
	}

	private static function hr()
	{
		$link          = [];
		$link['type']  = 'hr';
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
		$salawat          = [];
		$salawat['type']  = 'salawat';
		$salawat['count'] = \lib\db\salavats::shomar();
		return $salawat;
	}



}
?>