<?php
namespace content_m\karbalasetting\home;


class model
{
	public static function post()
	{

		\dash\permission::access('mKarbalaSetting');
		\dash\notif::warn('not now!');


	}
}
?>