<?php
namespace content\donate;

class model extends \mvc\model
{
	public function post_donate()
	{
		$args =
		[
			'username' => \lib\request::post('username'),
			'bank'     => mb_strtolower(\lib\request::post('bank')),
			'niyat'    => \lib\request::post('niyat'),
			'way'      => \lib\request::post('way'),
			'fullname' => \lib\request::post('fullname'),
			'email'    => \lib\request::post('email'),
			'mobile'   => \lib\request::post('mobile'),
			'amount'   => \lib\request::post('amount'),
			'doners'   => \lib\request::post('doners') === 'yes' ? 1 : 0,
		];

		if(!in_array(mb_strtolower(\lib\request::post('bank')), ['asanpardakht', 'zarinpal', 'payir']))

		$redirect = false;
		if(\lib\permission::access('admin'))
		{
			$redirect = true;
			$args['manuall'] = \lib\request::post('manualPay');
		}

		\lib\app\donate::add($args);

		if($redirect)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>