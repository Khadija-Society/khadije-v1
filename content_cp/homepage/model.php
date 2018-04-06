<?php
namespace content_cp\homepage;


class model extends \content_cp\main2\model
{
	public function post_staticvar()
	{
		$qom = \dash\request::post('qom');
		if(!$qom)
		{
			\lib\notif::error(T_("Please set the qom var"), 'qom');
			return false;
		}

		$qom = \dash\utility\convert::to_en_number($qom);
		if(!is_numeric($qom))
		{
			\lib\notif::error(T_("Please set the number of qom"));
			return false;
		}

		$qom = intval($qom);


		$mashhad = \dash\request::post('mashhad');
		if(!$mashhad)
		{
			\lib\notif::error(T_("Please set the mashhad var"), 'mashhad');
			return false;
		}

		$mashhad = \dash\utility\convert::to_en_number($mashhad);
		if(!is_numeric($mashhad))
		{
			\lib\notif::error(T_("Please set the number of mashhad"));
			return false;
		}

		$mashhad = intval($mashhad);


		$karbala = \dash\request::post('karbala');
		if(!$karbala)
		{
			\lib\notif::error(T_("Please set the karbala var"), 'karbala');
			return false;
		}

		$karbala = \dash\utility\convert::to_en_number($karbala);
		if(!is_numeric($karbala))
		{
			\lib\notif::error(T_("Please set the number of karbala"));
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

		if(\lib\engine\process::status())
		{
			\lib\notif::ok(T_("Data saved"));
		}

		\lib\redirect::pwd();

	}
}
?>
