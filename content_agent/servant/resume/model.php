<?php
namespace content_agent\servant\resume;


class model
{
	public static function post()
	{

		if(\dash\request::post('mod') === 'remove')
		{
			\lib\app\resume::remove(\dash\request::get('id'));
			$get = \dash\request::get();
			unset($get['id']);
			$get = '?'. http_build_query($get);
			\dash\redirect::to(\dash\url::that(). $get);
		}
		else
		{

			$post  =
			[
				'company'   => \dash\request::post('company'),
				'type'      => \dash\request::post('type'),
				'ceo'       => \dash\request::post('ceo'),
				'startdate' => \dash\request::post('startdate'),
				'enddate'   => \dash\request::post('enddate'),
				'desc'      => \dash\request::post('desc'),
				'user_id'   => \dash\request::get('user'),
			];

			if(\dash\request::get('id'))
			{
				\lib\app\resume::edit($post, \dash\request::get('id'));

				if(\dash\engine\process::status())
				{
					\dash\notif::ok(T_("Data saved"));
					$get = \dash\request::get();
					unset($get['id']);
					$get = '?'. http_build_query($get);
					\dash\redirect::to(\dash\url::that(). $get);
				}
			}
			else
			{
				\lib\app\resume::add($post);
			}
		}


		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Data saved"));
			\dash\redirect::to(\dash\url::pwd());
		}
	}
}
?>