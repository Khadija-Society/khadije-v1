<?php
namespace content\home;


class model extends \mvc\model
{
	public function post_donate()
	{
		$meta =
		[
			'turn_back'   => \dash\url::base(). '/doners',
			'other_field' =>
			[
				// 'hazinekard' => $way,
				// 'niyat'      => $niyat,
				'fullname'   => \dash\user::login('displayname'),
				'donate'     => 'cash',
				'doners'     => 0,
			]
		];

		\dash\utility\payment\pay::start(\dash\user::id(), 'asanpardakht', \dash\request::post('quickpay'), $meta);
	}

}
?>