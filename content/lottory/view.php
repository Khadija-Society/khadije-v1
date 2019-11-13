<?php
namespace content\lottory;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Signup karbala"));
		\dash\data::page_desc(\dash\data::site_desc());

		$winners = self::load_level();
		if(!$winners)
		{
			$winners = self::winners(); // test or sample
		}

		\dash\data::winners(json_encode($winners , JSON_UNESCAPED_UNICODE));
		\dash\data::winnersList($winners);
	}



	private static function winners()
	{
		$winners =
		'[
			{"index":1,"name":"رضامحیطی","mobile":"989109610612","id":"4440032109","father":"احمد","province":"قم","skip":true},
			{"index":2,"name":"محمد‌مهدیپیرنجم‌الدین","mobile":"989131881682","id":"1277775702","father":"بهرام","province":"اصفهان","skip":true},
			{"index":3,"name":"یوسفآهنگرانیفراهانی","mobile":"989309216163","id":"0055149138","father":"احمد","province":"تهران","skip":true},
			{"index":4,"name":"امالبنینکشاورز","mobile":"989038925304","id":"0925539041","father":"حسین","province":"خراسانرضوی","skip":true},
			{"index":5,"name":"سمانهصدیقی","mobile":"989300978323","id":"1064027253","father":"لطفاله","province":"خراسانرضوی","skip":true},
			{"index":6,"name":"فاطمهاورعی","mobile":"989371795377","id":"0069453896","father":"مرتضی","province":"تهران","skip":false},
			{"index":7,"name":"حسناحمدی","mobile":"989221548993","id":"2121850570","father":"مرادعلی","province":"گلستان","skip":false},
			{"index":8,"name":"ساراسادسیزر","mobile":"989011643508","id":"0018919170","father":"نصراله","province":"تهران","skip":false},
			{"index":9,"name":"مهدیولیزاده","mobile":"989358054009","id":"0080683673","father":"محمدصادق","province":"تهران","skip":false},
			{"index":10,"name":"علینظاریابر","mobile":"989147674917","id":"1640281207","father":"اصغر","province":"آذربایجانشرقی","skip":false},
			{"index":11,"name":"محمدحمیدی","mobile":"989189638427","id":"0621747599","father":"عزیزالله","province":"مرکزی","skip":false},
			{"index":12,"name":"عزتاللهحمیدی","mobile":"989379304628","id":"0533341809","father":"عزیزالله","province":"مرکزی","skip":false},
			{"index":13,"name":"محمدهمتی","mobile":"989185257548","id":"0520347935","father":"محمدتقی","province":"مرکزی","skip":false},
			{"index":14,"name":"صدیقهسلمانیزارچی","mobile":"989132529007","id":"5519798648","father":"حسن","province":"یزد","skip":false},
			{"index":15,"name":"حسینصلحمیرزایی","mobile":"989374259134","id":"3970106877","father":"وجیههالله","province":"تهران","skip":false},
			{"index":16,"name":"تیموربهرامیکمرزردی","mobile":"989189326455","id":"3340891133","father":"جهانگیر","province":"کرمانشاه","skip":false},
			{"index":17,"name":"حسینزرتابی","mobile":"989129794962","id":"0075214938","father":"یدالله","province":"تهران","skip":false},
			{"index":18,"name":"طیبهاحسانینیک","mobile":"989188486755","id":"0532401115","father":"علیاصغر","province":"مرکزی","skip":false},
			{"index":19,"name":"فاطمهخوشدونی","mobile":"989034319341","id":"0521181089","father":"غلامرضا","province":"تهران","skip":false},
			{"index":20,"name":"شعبانحبیبیامزاجردی","mobile":"912364766","id":"3875052961","father":"امینالله","province":"تهران","skip":false}
		]';

		return json_decode($winners, true);
	}


	public static function load_level()
	{

		// md5 of level url
		$level = \dash\request::get('level');
		// 32 md5 and step level >= 32
		if(mb_strlen($level) >= 32)
		{
			$md5  = substr($level, 0, 32);
			$step = substr($level, 32);

			if($step && !is_numeric($step))
			{
				\dash\header::status(404, T_("Invalid step"));
				return false;
			}

			$load_level = \lib\app\lottery::load_lottery('karbala2users', $md5, $step);
			return $load_level;

		}
		else
		{
			return;
		}

	}
}
?>
