<?php
namespace content_a\service\detail;


class model extends \content_a\main\model
{

	public function post_detail()
	{

		$post                = [];
		$post['expertvalue'] = \lib\utility::post('expertvalue');
		$post['expertyear']  = \lib\utility::post('expertyear');
		$post['job']         = \lib\utility::post('job');
		$post['arabiclang']  = \lib\utility::post('ArabicLang');
		$post['startdate']   = \lib\utility::post('startdate');
		$post['enddate']     = \lib\utility::post('enddate');
		$post['car']         = \lib\utility::post('car');
		$post['desc']        = \lib\utility::post('desc');
		$post['status']        = 'awaiting';


		\lib\app\service::edit($post, \lib\utility::get('id'));

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Detail was saved"));
			$this->redirector($this->url('baseFull'). '/service');
		}
	}
}
?>
