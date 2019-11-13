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
			{"index":1,"name":"جواد ادیب","mobile":"989109610612","id":"444**32109","nationalcode":"4440032109","father":"احمد","province":"قم","status":"ok"},
			{"index":2,"name":"جواد ادیب","mobile":"989131881682","id":"127**75702","nationalcode":"1277775702","father":"بهرام","province":"اصفهان","status":"ok"},
			{"index":3,"name":"جواد ادیب","mobile":"989309216163","id":"005**49138","nationalcode":"0055149138","father":"احمد","province":"تهران","status":"run"},
			{"index":4,"name":"جواد ادیب","mobile":"989038925304","id":"092**39041","nationalcode":"0925539041","father":"حسین","province":"خراسانرضوی","status":"run"},
			{"index":5,"name":"جواد ادیب","mobile":"989300978323","id":"106**27253","nationalcode":"1064027253","father":"لطفاله","province":"خراسانرضوی","status":"run"},
			{"index":6,"name":"جواد ادیب","mobile":"989371795377","id":"006**53896","nationalcode":"0069453896","father":"مرتضی","province":"تهران","status":"none"},
			{"index":7,"name":"جواد ادیب","mobile":"989221548993","id":"212**50570","nationalcode":"2121850570","father":"مرادعلی","province":"گلستان","status":"none"},
			{"index":8,"name":"جواد ادیب","mobile":"989011643508","id":"001**19170","nationalcode":"0018919170","father":"نصراله","province":"تهران","status":"none"},
			{"index":9,"name":"جواد ادیب","mobile":"989358054009","id":"008**83673","nationalcode":"0080683673","father":"محمدصادق","province":"تهران","status":"none"},
			{"index":10,"name":"جواد ادیب","mobile":"989147674917","id":"164**81207","nationalcode":"1640281207","father":"اصغر","province":"آذربایجانشرقی","status":"none"},
			{"index":11,"name":"جواد ادیب","mobile":"989189638427","id":"062**47599","nationalcode":"0621747599","father":"عزیزالله","province":"مرکزی","status":"none"},
			{"index":12,"name":"جواد ادیب","mobile":"989379304628","id":"053**41809","nationalcode":"0533341809","father":"عزیزالله","province":"مرکزی","status":"none"},
			{"index":13,"name":"جواد ادیب","mobile":"989185257548","id":"052**47935","nationalcode":"0520347935","father":"محمدتقی","province":"مرکزی","status":"none"},
			{"index":14,"name":"جواد ادیب","mobile":"989132529007","id":"551**98648","nationalcode":"5519798648","father":"حسن","province":"یزد","status":"none"},
			{"index":15,"name":"جواد ادیب","mobile":"989374259134","id":"397**06877","nationalcode":"3970106877","father":"وجیههالله","province":"تهران","status":"none"},
			{"index":16,"name":"جواد ادیب","mobile":"989189326455","id":"334**91133","nationalcode":"3340891133","father":"جهانگیر","province":"کرمانشاه","status":"none"},
			{"index":17,"name":"جواد ادیب","mobile":"989129794962","id":"007**14938","nationalcode":"0075214938","father":"یدالله","province":"تهران","status":"none"},
			{"index":18,"name":"جواد ادیب","mobile":"989188486755","id":"053**01115","nationalcode":"0532401115","father":"علیاصغر","province":"مرکزی","status":"none"},
			{"index":19,"name":"جواد ادیب","mobile":"989034319341","id":"052**81089","nationalcode":"0521181089","father":"غلامرضا","province":"تهران","status":"none"},
			{"index":20,"name":"جواد ادیب","mobile":"912364766","id":"387**52961","nationalcode":"3875052961","father":"امینالله","province":"تهران","status":"none"}
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
