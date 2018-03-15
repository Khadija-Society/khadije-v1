<?php
namespace content_a\service\detail;


class model extends \content_a\main\model
{

	public function post_detail()
	{

		$post                = [];
		$post['expertvalue'] = \lib\request::post('expertvalue');
		$post['expertyear']  = \lib\request::post('expertyear');
		$post['job']         = \lib\request::post('job');
		$post['arabiclang']  = \lib\request::post('ArabicLang');
		$post['startdate']   = \lib\request::post('startdate');
		$post['enddate']     = \lib\request::post('enddate');
		$post['car']         = \lib\request::post('car');
		$post['desc']        = \lib\request::post('desc');
		$post['status']        = 'awaiting';


		\lib\app\service::edit($post, \lib\utility::get('id'));

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Detail was saved"));
			$this->redirector(\lib\url::here(). '/service');
		}
	}
}
?>
