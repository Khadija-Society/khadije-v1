<?php
namespace content_api\v6\salawat;


class controller
{
	public static function routing()
	{
		if(!\dash\request::is('post'))
		{
			\content_api\v6::no(404);
		}

		\content_api\v6::check_appkey();

		$count = \lib\db\salavats::befrest();

		\dash\notif::info(T_("Allahouma sali ala mohamed wa ali muhammad"));


		$salawat              =  [];;
		$salawat['count']     = $count;
		$salawat['fit_count'] = \dash\utility\human::fitNumber($count);

		\content_api\v6::bye($salawat);
	}
}
?>