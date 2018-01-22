<?php
namespace content_cp\homepage;


class model extends \content_cp\main2\model
{
	public function post_staticvar()
	{
		$qom = \lib\utility::post('qom');
		if(!$qom)
		{
			\lib\debug::error(T_("Please set the qom var"), 'qom');
			return false;
		}

		$qom = \lib\utility\convert::to_en_number($qom);
		if(!is_numeric($qom))
		{
			\lib\debug::error(T_("Please set the number of qom"));
			return false;
		}

		$qom = intval($qom);


		$mashhad = \lib\utility::post('mashhad');
		if(!$mashhad)
		{
			\lib\debug::error(T_("Please set the mashhad var"), 'mashhad');
			return false;
		}

		$mashhad = \lib\utility\convert::to_en_number($mashhad);
		if(!is_numeric($mashhad))
		{
			\lib\debug::error(T_("Please set the number of mashhad"));
			return false;
		}

		$mashhad = intval($mashhad);


		$karbala = \lib\utility::post('karbala');
		if(!$karbala)
		{
			\lib\debug::error(T_("Please set the karbala var"), 'karbala');
			return false;
		}

		$karbala = \lib\utility\convert::to_en_number($karbala);
		if(!is_numeric($karbala))
		{
			\lib\debug::error(T_("Please set the number of karbala"));
			return false;
		}

		$karbala = intval($karbala);

		$result ="$qom\n$mashhad\n$karbala";

		$url    = root. 'public_html/files/data/';
		if(!\lib\utility\file::exists($url))
		{
			\lib\utility\file::makeDir($url, null, true);
		}

		$url .= 'staticvar.txt';
		if(!\lib\utility\file::exists($url))
		{
			\lib\utility\file::write($url, $result);
		}
		else
		{
			\lib\utility\file::write($url, $result);
		}

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Data saved"));
		}

		$this->redirector($this->url('full'));

	}
}
?>
