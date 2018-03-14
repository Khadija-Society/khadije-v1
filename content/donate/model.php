<?php
namespace content\donate;

class model extends \mvc\model
{
	public function post_donate()
	{
		$args =
		[
			'username' => \lib\utility::post('username'),
			'bank'     => mb_strtolower(\lib\utility::post('bank')),
			'niyat'    => \lib\utility::post('niyat'),
			'way'      => \lib\utility::post('way'),
			'fullname' => \lib\utility::post('fullname'),
			'email'    => \lib\utility::post('email'),
			'mobile'   => \lib\utility::post('mobile'),
			'amount'   => \lib\utility::post('amount'),
			'doners'   => \lib\utility::post('doners') === 'yes' ? 1 : 0,
		];

		if(!in_array(mb_strtolower(\lib\utility::post('bank')), ['asanpardakht', 'zarinpal', 'payir']))

		$redirect = false;
		if(\lib\permission::access('admin'))
		{
			$redirect = true;
			$args['manuall'] = \lib\utility::post('manualPay');
		}

		\lib\app\donate::add($args);

		if($redirect)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>