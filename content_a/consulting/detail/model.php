<?php
namespace content_a\consulting\detail;


class model
{

	public static function post()
	{

		$post                = [];
		// $post['expertvalue'] = \dash\request::post('expertvalue');
		// $post['expertyear']  = \dash\request::post('expertyear');
		// $post['job']         = \dash\request::post('job');
		// $post['arabiclang']  = \dash\request::post('ArabicLang');
		// $post['startdate']   = \dash\request::post('startdate');
		// $post['enddate']     = \dash\request::post('enddate');
		// $post['car']         = \dash\request::post('car');
		// $post['desc']        = \dash\request::post('desc');
		$post['status']      = \dash\request::post('status') === 'awaiting' ? 'awaiting' : 'cancel';
		$post['type']        = 'consulting';


		\lib\app\service::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your consulting request was saved"));
			\dash\redirect::to(\dash\url::here(). '/consulting');
		}
	}
}
?>
