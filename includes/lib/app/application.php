<?php
namespace lib\app;

class application
{

	public static function detail_v6()
	{
		$detail             = [];
		$detail['version']  = self::version();
		$detail['homepage'] = self::homepage();
		$detail['intro']    = self::intro();
		return $detail;
	}


	private static function version()
	{
		$detail                     = [];
		$detail['last']             = 43;
		$detail['deprecated']       = 34;
		$detail['deprecated_title'] = T_("This version is deprecated");
		$detail['deprecated_desc']  = T_("To download new version of this app click blow link");
		$detail['update_title']     = T_("New version is released");
		$detail['update_desc']      = T_("To download new version of this app click blow link");

		return $detail;
	}

	private static function intro()
	{
		$intro   = [];
		$intro[] =
		[
			'title'       => T_(\dash\option::config('site','title')),
			'desc'        => 'تمام خدمات موسسه در یک اپلیکیشن',
			'bg_from'     => '#ffffff',
			'bg_to'       => '#ffffff',
			'title_color' => '#000000',
			'desc_color'  => '#000000',
			'image'       => \dash\url::static(). '/images/app/app-splash-1.jpg',
			'btn'         =>
			[
				[
					'title'  => T_("Next"),
					'action' => 'next',
				],
			],
		];

		$intro[] =
		[
			'title'       => T_('Easy'),
			'desc'        => 'روشی ساده برای پرداخت کمک‌های شما به زايرین',
			'bg_from'     => '#ffffff',
			'bg_to'       => '#ffffff',
			'title_color' => '#000000',
			'desc_color'  => '#000000',
			'image'       => \dash\url::static(). '/images/app/app-splash-2.jpg',
			'btn'         =>
			[
				[
					'title'  => T_("Prev"),
					'action' => 'prev',
				],
				[
					'title'  => T_("Next"),
					'action' => 'next',
				],
			],
		];

		$intro[] =
		[
			'title'       => 'ثبت‌نام کربلا',
			'desc'        => 'توانایی ثبت‌نام کربلا ویژه برنامه‌های تلویزیونی',
			'bg_from'     => '#ffffff',
			'bg_to'       => '#ffffff',
			'title_color' => '#000000',
			'desc_color'  => '#000000',
			'image'       => \dash\url::static(). '/images/app/app-splash-4.jpg',
			'btn'         =>
			[
				[
					'title'  => T_("Prev"),
					'action' => 'prev',
				],
				[
					'title'  => T_("Next"),
					'action' => 'next',
				],
			],
		];

		$intro[] =
		[
			'title'       => T_(\dash\option::config('site','title')),
			'desc'        => 'مجری طرح زاير اولی‌های اهل بیت علیه اسلام',
			'bg_from'     => '#ffffff',
			'bg_to'       => '#ffffff',
			'title_color' => '#000000',
			'desc_color'  => '#000000',
			'image'       => \dash\url::static(). '/images/logo.png',
			'btn' =>
			[
				[
					'title'  => T_("Start"),
					'action' => 'start',
				],
			],
		];

		return $intro;
	}



	private static function homepage()
	{
		$homepage              = [];
		// $homepage[]            = self::karbala_signup_link();

		// if(\lib\app\syslottery::any_active())
		{
			// $homepage[]            = self::competition_book();
		}

		$homepage[] = self::poyesh_nojavan_hoseyni();

		// $homepage[]            = self::link2_donate_shaban();
		$homepage[]            = self::link2_donate_ramazan();
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


	private static function lottery_link()
	{
		// @javad check the baner of lottery link
		$link          = [];
		$link['type']  = 'banner';
		// $link['type']  = 'browser';
		$link['image'] = \dash\url::static(). '/images/app/app-lottery.jpg';
		$link['image'] = \dash\url::static(). '/images/app/app-festival-tv.jpg';
		$link['url']   = \dash\url::kingdom(). '/l';
		return $link;
	}


	private static function poyesh_nojavan_hoseyni()
	{
		$link          = [];
		$link['type']  = 'banner';
		// $link['target'] = 'browser';
		$link['image'] = \dash\url::static(). '/images/app/banner-ghorbani.jpg';
		$link['url']   = \dash\url::kingdom(). '/donate?nazr=qorbani-aval-mah';

		return $link;
	}


	private static function competition_book()
	{
		$link          = [];
		$link['type']  = 'banner';
		// $link['type']  = 'browser';
		$link['target'] = 'browser';
		$link['image'] = \dash\url::static(). '/images/app/banner-ketabkhani99.jpg';
		//$link['url']   = \dash\url::kingdom(). '/race-ramezan-99';
		$link['url']   = 'https://sarshomar.com/fa/s/3L32G/ex';

		return $link;
	}

	private static function karbala_signup_link()
	{
		$link          = [];
		$link['type']  = 'banner';
		// $link['type']  = 'browser';
		$link['image'] = \dash\url::static(). '/images/app/karbala201909.jpg';
		$link['url']   = \dash\url::kingdom(). '/arbaeen98';
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
		$posts        = \dash\app\posts::get_post_list(['limit' => 5, 'language' => \dash\language::current()]);

		$new_post = [];

		foreach ($posts as $key => $value)
		{
			if(isset($value['meta']['redirect']) && $value['meta']['redirect'])
			{
				continue;
			}

			$new_post[] = $value;
		}

		$link['news'] = $new_post;

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

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/doyon-sharee-wide.jpg';
		$link['link'][1]['url']   = \dash\url::kingdom(). '/doyon';
		$link['link'][1]['text']  = T_('Donate Product');

		return $link;
	}


	private static function link2_donate_shaban()
	{
		$link                     = [];
		$link['type']             = 'link2';

		$link['link'][0]['image'] = \dash\url::static(). '/images/app/donate-nime-shaban-wide.jpg';
		$link['link'][0]['url']   = \dash\url::kingdom(). '/donate?nazr=shaban';
		$link['link'][0]['text']  = 'قربانی نیمه شعبان';

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/donate-aghighe-wide.jpg';
		$link['link'][1]['url']   = \dash\url::kingdom(). '/donate?nazr=aghighe';
		$link['link'][1]['text']  = 'قربانی عقیقه';

		return $link;
	}


	private static function link2_donate_ramazan()
	{
		$link                     = [];
		$link['type']             = 'link2';

		$link['link'][0]['image'] = \dash\url::static(). '/images/app/donate-wide.jpg';
		$link['link'][0]['url']   = \dash\url::kingdom(). '/donate';
		$link['link'][0]['text']  = T_('Donate');

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/donate-aghighe-wide.jpg';
		$link['link'][1]['url']   = \dash\url::kingdom(). '/donate?nazr=aghighe';
		$link['link'][1]['text']  = 'قربانی عقیقه';

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

		$link['link'][0]['image'] = \dash\url::static(). '/images/app/LastLine-services.jpg';
		$link['link'][0]['url']   = \dash\url::kingdom().'/support';
		$link['link'][0]['text']  = T_("Help Center");

		$link['link'][1]['image'] = \dash\url::static(). '/images/app/LastLine-website.jpg';
		$link['link'][1]['url']   = \dash\url::kingdom();
		$link['link'][1]['type']  = 'browser';
		$link['link'][1]['text']  = T_("Website");

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