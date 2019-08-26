<?php
namespace content\ghadir98;


class view extends \content_support\ticket\contact_ticket\view
{
	public static function config()
	{

		\dash\data::page_title("ارائه گزارش عملکرد دهه ولایت");
		\dash\data::page_desc(\dash\data::site_desc());

		$cityList    = \dash\utility\location\cites::$data;
		$proviceList = \dash\utility\location\provinces::key_list('localname');

		$new = [];
		foreach ($cityList as $key => $value)
		{
			$temp = '';

			if(isset($value['province']) && isset($proviceList[$value['province']]))
			{
				$temp .= $proviceList[$value['province']]. ' - ';
			}
			if(isset($value['localname']))
			{
				$temp .= $value['localname'];
			}
			$new[$key] = $temp;
		}
		asort($new);

		\dash\data::cityList($new);

		self::codeurl();
	}
}
?>