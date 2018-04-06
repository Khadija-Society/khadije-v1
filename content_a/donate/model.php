<?php
namespace content_a\donate;


class model extends \content_a\main\model
{

	public function post_donate()
	{
		$args =
		[
			'username' => \dash\request::post('username'),
			'niyat'    => \dash\request::post('niyat'),
			'way'      => \dash\request::post('way'),
			'fullname' => \dash\request::post('fullname'),
			'email'    => \dash\request::post('email'),
			'mobile'   => \dash\request::post('mobile'),
			'amount'   => \dash\request::post('amount'),
			'doners'   => \dash\request::post('doners') === 'yes' ? 1 : 0,
		];

		\lib\app\donate::add($args);
	}
}
?>
