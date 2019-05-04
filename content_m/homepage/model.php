<?php
namespace content_m\homepage;


class model
{
	public static function post()
	{
		\dash\permission::access('cpHomePageNumber');

		$qom = \dash\request::post('qom');
		if(!$qom)
		{
			\dash\notif::error(T_("Please set the qom var"), 'qom');
			return false;
		}

		$qom = \dash\utility\convert::to_en_number($qom);
		if(!is_numeric($qom))
		{
			\dash\notif::error(T_("Please set the number of qom"));
			return false;
		}

		$qom = intval($qom);


		$mashhad = \dash\request::post('mashhad');
		if(!$mashhad)
		{
			\dash\notif::error(T_("Please set the mashhad var"), 'mashhad');
			return false;
		}

		$mashhad = \dash\utility\convert::to_en_number($mashhad);
		if(!is_numeric($mashhad))
		{
			\dash\notif::error(T_("Please set the number of mashhad"));
			return false;
		}

		$mashhad = intval($mashhad);


		$karbala = \dash\request::post('karbala');
		if(!$karbala)
		{
			\dash\notif::error(T_("Please set the karbala var"), 'karbala');
			return false;
		}

		$karbala = \dash\utility\convert::to_en_number($karbala);
		if(!is_numeric($karbala))
		{
			\dash\notif::error(T_("Please set the number of karbala"));
			return false;
		}

		$karbala = intval($karbala);

		$result ="$qom\n$mashhad\n$karbala";

		$url    = root. 'public_html/files/data/';
		if(!\dash\file::exists($url))
		{
			\dash\file::makeDir($url, null, true);
		}

		$url .= 'staticvar.txt';
		if(!\dash\file::exists($url))
		{
			\dash\file::write($url, $result);
		}
		else
		{
			\dash\file::write($url, $result);
		}

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Data saved"));
		}

		\dash\redirect::pwd();

	}
}
?>
