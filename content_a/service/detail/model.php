<?php
namespace content_a\service\detail;


class model extends \content_a\main\model
{

	public function post_detail()
	{

		$post                = [];
		$post['expertvalue'] = \dash\request::post('expertvalue');
		$post['expertyear']  = \dash\request::post('expertyear');
		$post['job']         = \dash\request::post('job');
		$post['arabiclang']  = \dash\request::post('ArabicLang');
		$post['startdate']   = \dash\request::post('startdate');
		$post['enddate']     = \dash\request::post('enddate');
		$post['car']         = \dash\request::post('car');
		$post['desc']        = \dash\request::post('desc');
		$post['status']        = 'awaiting';


		\lib\app\service::edit($post, \dash\request::get('id'));

		if(\lib\engine\process::status())
		{
			\lib\notif::ok(T_("Detail was saved"));
			\lib\redirect::to(\dash\url::here(). '/service');
		}
	}
}
?>
