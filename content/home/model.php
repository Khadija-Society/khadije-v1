<?php
namespace content\home;


class model
{
	public static function post()
	{
		if(\dash\request::post('salavat'))
		{
			\dash\temp::set('force_stop_visitor', true);
			$count = \lib\db\salavats::befrest();
			// \dash\notif::info(T_("Allahouma sali ala mohamed wa ali muhammad"),
			// 	[
			// 		'position'=> 'bottomCenter',
			// 		'timeout' => '3000',
			// 		'icon' => 'sf-heart',
			// 		'theme' => 'dark',
			// 		'iconColor'=> '#020456'
			// 	]
			// );
			\dash\notif::result($count);
			return;
		}

		$args =
		[
			'username'  => null,
			'bank'      => null,
			'niyat'     => null,
			'way'       => null,
			'fullname'  => \dash\user::login('displayname'),
			'email'     => null,
			'mobile'    => null,
			'amount'    => \dash\request::post('quickpay'),
			'doners'    => 0,
			'turn_back' => \dash\url::kingdom(). '/doners',
			'auto_go'   => true,
		];

		\lib\app\donate::add($args);


		// $meta =
		// [
		// 	'turn_back'   => \dash\url::kingdom(). '/doners',
		// 	'user_id'     => \dash\user::id(),
		// 	'amount'      => \dash\request::post('quickpay'),
		// 	'auto_go'     => true,
		// 	'auto_back'   => true,
		// 	'final_msg'   => true,
		// 	'other_field' =>
		// 	[
		// 		// 'hazinekard' => $way,
		// 		// 'niyat'      => $niyat,
		// 		'fullname'   => \dash\user::login('displayname'),
		// 		'donate'     => 'cash',
		// 		'doners'     => 0,
		// 	]
		// ];

		// \dash\utility\pay\start::site($meta);

	}

}
?>