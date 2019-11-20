<?php
namespace content\karbala\lottery2;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Signup karbala"));
		\dash\data::page_desc(\dash\data::site_desc());

		$winners = self::load_level();

		if(!$winners && \dash\request::get('sample'))
		{
			$winners = self::winners(\dash\request::get('sample')); // test or sample
		}

		\dash\data::winners(json_encode($winners , JSON_UNESCAPED_UNICODE));

		\dash\data::winnersList($winners);
	}



	private static function winners($_sample = null)
	{

		switch ($_sample)
		{
			case '15':
				$winners =
				'[
					{"index":1,"name":"آقای تست بشماره یک","mobile":"989109610612","id":"444**32109","nationalcode":"4440032109","father":"احمد","province":"قم","city":"قم","status":"ok"},
					{"index":2,"name":"خانم تست شماره دو","mobile":"989131881682","id":"127**75702","nationalcode":"1277775702","father":"بهرام","province":"اصفهان","city":"اصفهان","status":"ok"},
					{"index":3,"name":"اقای تست تست شماره سه","mobile":"989309216163","id":"005**49138","nationalcode":"0055149138","father":"احمد","province":"تهران","city":"تهران","status":"ok"},
					{"index":4,"name":"آقای تست شماره چهارتست","mobile":"989038925304","id":"092**39041","nationalcode":"0925539041","father":"حسین","province":"خراسان رضوی","city":"مشهد","status":"ok"},
					{"index":5,"name":"آقای تست شماره پنج","mobile":"989300978323","id":"106**27253","nationalcode":"1064027253","father":"لطف اله","province":"خراسان رضوی","city":"نیشابور","status":"ok"},
					{"index":6,"name":"تست","mobile":"989371795377","id":"006**53896","nationalcode":"0069453896","father":"مرتضی","province":"تهران","city":"تهران","status":"ok"},
					{"index":7,"name":"تست","mobile":"989221548993","id":"212**50570","nationalcode":"2121850570","father":"مراد علی","province":"گلستان","city":"گرگان","status":"ok"},
					{"index":8,"name":"تست","mobile":"989011643508","id":"001**19170","nationalcode":"0018919170","father":"نصراله","province":"تهران","city":"تهران","status":"ok"},
					{"index":9,"name":"تست","mobile":"989358054009","id":"008**83673","nationalcode":"0080683673","father":"محمدصادق","province":"تهران","city":"بهارستان","status":"ok"},
					{"index":10,"name":"تست","mobile":"989147674917","id":"164**81207","nationalcode":"1640281207","father":"اصغر","province":"آذربایجان شرقی","city":"تبریز","status":"ok"},
					{"index":11,"name":"تست","mobile":"989189638427","id":"062**47599","nationalcode":"0621747599","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"ok"},
					{"index":12,"name":"تست","mobile":"989379304628","id":"053**41809","nationalcode":"0533341809","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"ok"},
					{"index":13,"name":"تست","mobile":"989185257548","id":"052**47935","nationalcode":"0520347935","father":"محمدتقی","province":"مرکزی","city":"اراک","status":"ok"},
					{"index":14,"name":"تست","mobile":"989132529007","id":"551**98648","nationalcode":"5519798648","father":"حسن","province":"یزد","city":"یزد","status":"ok"},
					{"index":15,"name":"تست","mobile":"989374259134","id":"397**06877","nationalcode":"3970106877","father":"وجیهه الله","province":"تهران","city":"تهران","status":"ok"},
					{"index":16,"name":"تست","mobile":"989189326455","id":"334**91133","nationalcode":"3340891133","father":"جهانگیر","province":"کرمانشاه","city":"کرمانشاه","status":"ok"},
					{"index":17,"name":"تست","mobile":"989129794962","id":"007**14938","nationalcode":"0075214938","father":"یدالله","province":"تهران","city":"تهران","status":"ok"},
					{"index":18,"name":"تست","mobile":"989188486755","id":"053**01115","nationalcode":"0532401115","father":"علی اصغر","province":"مرکزی","city":"اراک","status":"ok"},
					{"index":19,"name":"تست","mobile":"989034319341","id":"052**81089","nationalcode":"0521181089","father":"غلامرضا","province":"تهران","city":"پاکدشت","status":"ok"},
					{"index":20,"name":"تست","mobile":"912364766","id":"387**52961","nationalcode":"3875052961","father":"امین الله","province":"تهران","city":"شهریار","status":"ok"}
				]';
				break;

			case '14':
				$winners =
					// {"index":1,"name":"تست","mobile":"989109610612","id":"444**32109","nationalcode":"4440032109","father":"احمد","province":"قم","city":"قم","status":"ok"},
					// {"index":2,"name":"تست","mobile":"989131881682","id":"127**75702","nationalcode":"1277775702","father":"بهرام","province":"اصفهان","city":"اصفهان","status":"ok"},
					// {"index":3,"name":"تست","mobile":"989309216163","id":"005**49138","nationalcode":"0055149138","father":"احمد","province":"تهران","city":"تهران","status":"ok"},
					// {"index":4,"name":"تست","mobile":"989038925304","id":"092**39041","nationalcode":"0925539041","father":"حسین","province":"خراسان رضوی","city":"مشهد","status":"ok"},
					// {"index":5,"name":"تست","mobile":"989300978323","id":"106**27253","nationalcode":"1064027253","father":"لطف اله","province":"خراسان رضوی","city":"نیشابور","status":"ok"},
					// {"index":6,"name":"تست","mobile":"989371795377","id":"006**53896","nationalcode":"0069453896","father":"مرتضی","province":"تهران","city":"تهران","status":"ok"},
					// {"index":7,"name":"تست","mobile":"989221548993","id":"212**50570","nationalcode":"2121850570","father":"مراد علی","province":"گلستان","city":"گرگان","status":"ok"},
					// {"index":8,"name":"تست","mobile":"989011643508","id":"001**19170","nationalcode":"0018919170","father":"نصراله","province":"تهران","city":"تهران","status":"ok"},
					// {"index":9,"name":"تست","mobile":"989358054009","id":"008**83673","nationalcode":"0080683673","father":"محمدصادق","province":"تهران","city":"بهارستان","status":"ok"},
					// {"index":10,"name":"تست","mobile":"989147674917","id":"164**81207","nationalcode":"1640281207","father":"اصغر","province":"آذربایجان شرقی","city":"تبریز","status":"ok"},
					// {"index":11,"name":"تست","mobile":"989189638427","id":"062**47599","nationalcode":"0621747599","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"ok"},
					// {"index":12,"name":"تست","mobile":"989379304628","id":"053**41809","nationalcode":"0533341809","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"ok"},
					// {"index":13,"name":"تست","mobile":"989185257548","id":"052**47935","nationalcode":"0520347935","father":"محمدتقی","province":"مرکزی","city":"اراک","status":"ok"},
					// {"index":14,"name":"تست","mobile":"989132529007","id":"551**98648","nationalcode":"5519798648","father":"حسن","province":"یزد","city":"یزد","status":"ok"},
					// {"index":15,"name":"تست","mobile":"989374259134","id":"397**06877","nationalcode":"3970106877","father":"وجیهه الله","province":"تهران","city":"تهران","status":"ok"},
				'[
					{"index":16,"name":"تست","mobile":"989189326455","id":"334**91133","nationalcode":"3340891133","father":"جهانگیر","province":"کرمانشاه","city":"کرمانشاه","status":"run"},
					{"index":17,"name":"تست","mobile":"989129794962","id":"007**14938","nationalcode":"0075214938","father":"یدالله","province":"تهران","city":"تهران","status":"run"},
					{"index":18,"name":"تست","mobile":"989188486755","id":"053**01115","nationalcode":"0532401115","father":"علی اصغر","province":"مرکزی","city":"اراک","status":"run"},
					{"index":19,"name":"تست","mobile":"989034319341","id":"052**81089","nationalcode":"0521181089","father":"غلامرضا","province":"تهران","city":"پاکدشت","status":"run"},
					{"index":20,"name":"تست","mobile":"912364766","id":"387**52961","nationalcode":"3875052961","father":"امین الله","province":"تهران","city":"شهریار","status":"run"}
				]';
				break;

			case '13':
				$winners =
					// {"index":1,"name":"تست","mobile":"989109610612","id":"444**32109","nationalcode":"4440032109","father":"احمد","province":"قم","city":"قم","status":"ok"},
					// {"index":2,"name":"تست","mobile":"989131881682","id":"127**75702","nationalcode":"1277775702","father":"بهرام","province":"اصفهان","city":"اصفهان","status":"ok"},
					// {"index":3,"name":"تست","mobile":"989309216163","id":"005**49138","nationalcode":"0055149138","father":"احمد","province":"تهران","city":"تهران","status":"ok"},
					// {"index":4,"name":"تست","mobile":"989038925304","id":"092**39041","nationalcode":"0925539041","father":"حسین","province":"خراسان رضوی","city":"مشهد","status":"ok"},
					// {"index":5,"name":"تست","mobile":"989300978323","id":"106**27253","nationalcode":"1064027253","father":"لطف اله","province":"خراسان رضوی","city":"نیشابور","status":"ok"},
					// {"index":6,"name":"تست","mobile":"989371795377","id":"006**53896","nationalcode":"0069453896","father":"مرتضی","province":"تهران","city":"تهران","status":"ok"},
					// {"index":7,"name":"تست","mobile":"989221548993","id":"212**50570","nationalcode":"2121850570","father":"مراد علی","province":"گلستان","city":"گرگان","status":"ok"},
					// {"index":8,"name":"تست","mobile":"989011643508","id":"001**19170","nationalcode":"0018919170","father":"نصراله","province":"تهران","city":"تهران","status":"ok"},
					// {"index":9,"name":"تست","mobile":"989358054009","id":"008**83673","nationalcode":"0080683673","father":"محمدصادق","province":"تهران","city":"بهارستان","status":"ok"},
					// {"index":10,"name":"تست","mobile":"989147674917","id":"164**81207","nationalcode":"1640281207","father":"اصغر","province":"آذربایجان شرقی","city":"تبریز","status":"ok"},
				'[
					{"index":11,"name":"تست","mobile":"989189638427","id":"062**47599","nationalcode":"0621747599","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"run"},
					{"index":12,"name":"تست","mobile":"989379304628","id":"053**41809","nationalcode":"0533341809","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"run"},
					{"index":13,"name":"تست","mobile":"989185257548","id":"052**47935","nationalcode":"0520347935","father":"محمدتقی","province":"مرکزی","city":"اراک","status":"run"},
					{"index":14,"name":"تست","mobile":"989132529007","id":"551**98648","nationalcode":"5519798648","father":"حسن","province":"یزد","city":"یزد","status":"run"},
					{"index":15,"name":"تست","mobile":"989374259134","id":"397**06877","nationalcode":"3970106877","father":"وجیهه الله","province":"تهران","city":"تهران","status":"run"}
				]';
					// {"index":16,"name":"تست","mobile":"989189326455","id":"334**91133","nationalcode":"3340891133","father":"جهانگیر","province":"کرمانشاه","city":"کرمانشاه","status":"none"},
					// {"index":17,"name":"تست","mobile":"989129794962","id":"007**14938","nationalcode":"0075214938","father":"یدالله","province":"تهران","city":"تهران","status":"none"},
					// {"index":18,"name":"تست","mobile":"989188486755","id":"053**01115","nationalcode":"0532401115","father":"علی اصغر","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":19,"name":"تست","mobile":"989034319341","id":"052**81089","nationalcode":"0521181089","father":"غلامرضا","province":"تهران","city":"پاکدشت","status":"none"},
					// {"index":20,"name":"تست","mobile":"912364766","id":"387**52961","nationalcode":"3875052961","father":"امین الله","province":"تهران","city":"شهریار","status":"none"}
				break;

			case '12':
				$winners =
					// {"index":1,"name":"تست","mobile":"989109610612","id":"444**32109","nationalcode":"4440032109","father":"احمد","province":"قم","city":"قم","status":"ok"},
					// {"index":2,"name":"تست","mobile":"989131881682","id":"127**75702","nationalcode":"1277775702","father":"بهرام","province":"اصفهان","city":"اصفهان","status":"ok"},
					// {"index":3,"name":"تست","mobile":"989309216163","id":"005**49138","nationalcode":"0055149138","father":"احمد","province":"تهران","city":"تهران","status":"ok"},
					// {"index":4,"name":"تست","mobile":"989038925304","id":"092**39041","nationalcode":"0925539041","father":"حسین","province":"خراسان رضوی","city":"مشهد","status":"ok"},
					// {"index":5,"name":"تست","mobile":"989300978323","id":"106**27253","nationalcode":"1064027253","father":"لطف اله","province":"خراسان رضوی","city":"نیشابور","status":"ok"},
				'[
					{"index":6,"name":"تست","mobile":"989371795377","id":"006**53896","nationalcode":"0069453896","father":"مرتضی","province":"تهران","city":"تهران","status":"run"},
					{"index":7,"name":"تست","mobile":"989221548993","id":"212**50570","nationalcode":"2121850570","father":"مراد علی","province":"گلستان","city":"گرگان","status":"run"},
					{"index":8,"name":"تست","mobile":"989011643508","id":"001**19170","nationalcode":"0018919170","father":"نصراله","province":"تهران","city":"تهران","status":"run"},
					{"index":9,"name":"تست","mobile":"989358054009","id":"008**83673","nationalcode":"0080683673","father":"محمدصادق","province":"تهران","city":"بهارستان","status":"run"},
					{"index":10,"name":"تست","mobile":"989147674917","id":"164**81207","nationalcode":"1640281207","father":"اصغر","province":"آذربایجان شرقی","city":"تبریز","status":"run"}
				]';

					// {"index":11,"name":"تست","mobile":"989189638427","id":"062**47599","nationalcode":"0621747599","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":12,"name":"تست","mobile":"989379304628","id":"053**41809","nationalcode":"0533341809","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":13,"name":"تست","mobile":"989185257548","id":"052**47935","nationalcode":"0520347935","father":"محمدتقی","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":14,"name":"تست","mobile":"989132529007","id":"551**98648","nationalcode":"5519798648","father":"حسن","province":"یزد","city":"یزد","status":"none"},
					// {"index":15,"name":"تست","mobile":"989374259134","id":"397**06877","nationalcode":"3970106877","father":"وجیهه الله","province":"تهران","city":"تهران","status":"none"},
					// {"index":16,"name":"تست","mobile":"989189326455","id":"334**91133","nationalcode":"3340891133","father":"جهانگیر","province":"کرمانشاه","city":"کرمانشاه","status":"none"},
					// {"index":17,"name":"تست","mobile":"989129794962","id":"007**14938","nationalcode":"0075214938","father":"یدالله","province":"تهران","city":"تهران","status":"none"},
					// {"index":18,"name":"تست","mobile":"989188486755","id":"053**01115","nationalcode":"0532401115","father":"علی اصغر","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":19,"name":"تست","mobile":"989034319341","id":"052**81089","nationalcode":"0521181089","father":"غلامرضا","province":"تهران","city":"پاکدشت","status":"none"},
					// {"index":20,"name":"تست","mobile":"912364766","id":"387**52961","nationalcode":"3875052961","father":"امین الله","province":"تهران","city":"شهریار","status":"none"}
				break;

			case '11':
			default:
				$winners =
				'[
					{"index":1,"name":"آقای محترم تست به شماره یک","mobile":"989109610612","id":"444**32109","nationalcode":"4440032109","father":"احمد","province":"قم","city":"قم","status":"run"},
					{"index":2,"name":"خانم تست شماره دو","mobile":"989131881682","id":"127**75702","nationalcode":"1277775702","father":"بهرام","province":"اصفهان","city":"اصفهان","status":"run"},
					{"index":3,"name":"آقای تست شماره سه ","mobile":"989309216163","id":"005**49138","nationalcode":"0055149138","father":"احمد","province":"تهران","city":"تهران","status":"run"},
					{"index":4,"name":"آقای تست شماره چهار","mobile":"989038925304","id":"092**39041","nationalcode":"0925539041","father":"حسین","province":"خراسان رضوی","city":"مشهد","status":"run"},
					{"index":5,"name":"آقای تست شمارهتست","mobile":"989300978323","id":"106**27253","nationalcode":"1064027253","father":"لطف اله","province":"خراسان رضوی","city":"نیشابور","status":"run"}
				]';

					// {"index":6,"name":"تست","mobile":"989371795377","id":"006**53896","nationalcode":"0069453896","father":"مرتضی","province":"تهران","city":"تهران","status":"none"},
					// {"index":7,"name":"تست","mobile":"989221548993","id":"212**50570","nationalcode":"2121850570","father":"مراد علی","province":"گلستان","city":"گرگان","status":"none"},
					// {"index":8,"name":"تست","mobile":"989011643508","id":"001**19170","nationalcode":"0018919170","father":"نصراله","province":"تهران","city":"تهران","status":"none"},
					// {"index":9,"name":"تست","mobile":"989358054009","id":"008**83673","nationalcode":"0080683673","father":"محمدصادق","province":"تهران","city":"بهارستان","status":"none"},
					// {"index":10,"name":"تست","mobile":"989147674917","id":"164**81207","nationalcode":"1640281207","father":"اصغر","province":"آذربایجان شرقی","city":"تبریز","status":"none"},
					// {"index":11,"name":"تست","mobile":"989189638427","id":"062**47599","nationalcode":"0621747599","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":12,"name":"تست","mobile":"989379304628","id":"053**41809","nationalcode":"0533341809","father":"عزیزالله","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":13,"name":"تست","mobile":"989185257548","id":"052**47935","nationalcode":"0520347935","father":"محمدتقی","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":14,"name":"تست","mobile":"989132529007","id":"551**98648","nationalcode":"5519798648","father":"حسن","province":"یزد","city":"یزد","status":"none"},
					// {"index":15,"name":"تست","mobile":"989374259134","id":"397**06877","nationalcode":"3970106877","father":"وجیهه الله","province":"تهران","city":"تهران","status":"none"},
					// {"index":16,"name":"تست","mobile":"989189326455","id":"334**91133","nationalcode":"3340891133","father":"جهانگیر","province":"کرمانشاه","city":"کرمانشاه","status":"none"},
					// {"index":17,"name":"تست","mobile":"989129794962","id":"007**14938","nationalcode":"0075214938","father":"یدالله","province":"تهران","city":"تهران","status":"none"},
					// {"index":18,"name":"تست","mobile":"989188486755","id":"053**01115","nationalcode":"0532401115","father":"علی اصغر","province":"مرکزی","city":"اراک","status":"none"},
					// {"index":19,"name":"تست","mobile":"989034319341","id":"052**81089","nationalcode":"0521181089","father":"غلامرضا","province":"تهران","city":"پاکدشت","status":"none"},
					// {"index":20,"name":"تست","mobile":"912364766","id":"387**52961","nationalcode":"3875052961","father":"امین الله","province":"تهران","city":"شهریار","status":"none"}
				break;
		}


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

			if(!$step)
			{
				\dash\header::status(404, T_("Invalid step"));
				return false;
			}

			$load_level = \lib\app\lottery::load_lottery('karbala2users', $md5, $step);
			$msg = \dash\temp::get('lotteryLevelMessage');
			\dash\data::lotteryLevelMessage($msg);

			$msg = \dash\temp::get('lotteryEndLevel');
			\dash\data::lotteryEndLevel($msg);

			return $load_level;

		}
		else
		{
			return;
		}

	}
}
?>
