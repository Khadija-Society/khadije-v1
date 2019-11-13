<?php
namespace content\karbala\lottery;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Signup karbala"));
		\dash\data::page_desc(\dash\data::site_desc());

		$winners = self::load_level();
		if(!$winners && \dash\request::get('sample'))
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
			{"index":1,"name":"رضا محیطیسیبسیبسیب","mobile":"989109610612","id":"444**32109","nationalcode":"4440032109","father":"احمد","province":"قم","city":"قم","status":"ok"},
			{"index":2,"name":"محمد‌مهدی پیرنجم‌الدین","mobile":"989131881682","id":"127**75702","nationalcode":"1277775702","father":"بهرام","province":"اصفهان","city":"اصفهان","status":"ok"},
			{"index":3,"name":"یوسف آهنگرانی فراهانی","mobile":"989309216163","id":"005**49138","nationalcode":"0055149138","father":"احمد","province":"تهران","city":"تهران","status":"ok"},
			{"index":4,"name":"ام البنین کشاورز","mobile":"989038925304","id":"092**39041","nationalcode":"0925539041","father":"حسین","province":"خراسان رضوی","city":"مشهد","status":"ok"},
			{"index":5,"name":"سمانه صدیقی","mobile":"989300978323","id":"106**27253","nationalcode":"1064027253","father":"لطف اله","province":"خراسان رضوی","city":"نیشابور","status":"ok"},
			{"index":6,"name":"فاطمه اورعی","mobile":"989371795377","id":"006**53896","nationalcode":"0069453896","father":"مرتضی","province":"تهران","city":"تهران","status":"run"},
			{"index":7,"name":"حسن احمدی","mobile":"989221548993","id":"212**50570","nationalcode":"2121850570","father":"مراد علی","province":"گلستان","city":"گرگان","status":"run"},
			{"index":8,"name":"سارا سادسی زر","mobile":"989011643508","id":"001**19170","nationalcode":"0018919170","father":"نصراله","province":"تهران","city":"تهران","status":"run"},
			{"index":9,"name":"مهدی ولی زاده","mobile":"989358054009","id":"008**83673","nationalcode":"0080683673","father":"محمدصادق","province":"تهران","city":"بهارستان","status":"run"},
			{"index":10,"name":"علی نظاری ابر","mobile":"989147674917","id":"164**81207","nationalcode":"1640281207","father":"اصغر","province":"آذربایجان شرقی","city":"تبریز","status":"run"},
			{"index":11,"name":"محمد حمیدی","mobile":"989189638427","id":"062**47599","nationalcode":"0621747599","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"none"},
			{"index":12,"name":"عزت الله حمیدی","mobile":"989379304628","id":"053**41809","nationalcode":"0533341809","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"none"},
			{"index":13,"name":"محمد همتی","mobile":"989185257548","id":"052**47935","nationalcode":"0520347935","father":"محمدتقی","province":"مرکزی","city":"اراک","status":"none"},
			{"index":14,"name":"صدیقه سلمانی زارچی","mobile":"989132529007","id":"551**98648","nationalcode":"5519798648","father":"حسن","province":"یزد","city":"یزد","status":"none"},
			{"index":15,"name":"حسین صلح میرزایی","mobile":"989374259134","id":"397**06877","nationalcode":"3970106877","father":"وجیهه الله","province":"تهران","city":"تهران","status":"none"},
			{"index":16,"name":"تیمور بهرامی کمرزردی","mobile":"989189326455","id":"334**91133","nationalcode":"3340891133","father":"جهانگیر","province":"کرمانشاه","city":"کرمانشاه","status":"none"},
			{"index":17,"name":"حسین زرتابی","mobile":"989129794962","id":"007**14938","nationalcode":"0075214938","father":"یدالله","province":"تهران","city":"تهران","status":"none"},
			{"index":18,"name":"طیبه احسانی نیک","mobile":"989188486755","id":"053**01115","nationalcode":"0532401115","father":"علی اصغر","province":"مرکزی","city":"اراک","status":"none"},
			{"index":19,"name":"فاطمه خوشدونی","mobile":"989034319341","id":"052**81089","nationalcode":"0521181089","father":"غلامرضا","province":"تهران","city":"پاکدشت","status":"none"},
			{"index":20,"name":"شعبان حبیبی امزاجردی","mobile":"912364766","id":"387**52961","nationalcode":"3875052961","father":"امین الله","province":"تهران","city":"شهریار","status":"none"}
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
