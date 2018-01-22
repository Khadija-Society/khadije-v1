<?php
namespace content\home;


class model extends \mvc\model
{
	public function post_donate()
	{
		$meta =
		[
			'turn_back'   => $this->url('base'). '/doners',
			'other_field' =>
			[
				// 'hazinekard' => $way,
				// 'niyat'      => $niyat,
				// 'fullname'   => $fullname,
				// 'donate'     => 'cash',
				// 'doners'     => $doners,
			]
		];

		\lib\utility\payment\pay::start(\lib\user::id(), 'asanpardakht', \lib\utility::post('quickpay'), $meta);
	}

}
?>