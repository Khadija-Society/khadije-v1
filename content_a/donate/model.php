<?php
namespace content_a\donate;


class model extends \content_a\main\model
{

	public function post_donate()
	{
		$args =
		[
			'username' => \lib\request::post('username'),
			'niyat'    => \lib\request::post('niyat'),
			'way'      => \lib\request::post('way'),
			'fullname' => \lib\request::post('fullname'),
			'email'    => \lib\request::post('email'),
			'mobile'   => \lib\request::post('mobile'),
			'amount'   => \lib\request::post('amount'),
			'doners'   => \lib\request::post('doners') === 'yes' ? 1 : 0,
		];

		\lib\app\donate::add($args);
	}
}
?>
