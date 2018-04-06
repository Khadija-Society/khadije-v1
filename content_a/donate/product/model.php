<?php
namespace content_a\donate\product;


class model extends \content_a\main\model
{

	public function post_donate()
	{
		if(\dash\request::post('username'))
		{
			\lib\notif::error(T_("Whate are you doing?"));
			return false;
		}

		$niyat = \dash\request::post('niyat');
		if(mb_strlen($niyat) > 150)
		{
			\lib\notif::error(T_("Please set niyat less than 150 character"), 'niyat');
			return false;
		}

		$way = \dash\request::post('way');
		if($way && !in_array($way, \lib\app\donate::way_list()))
		{
			\lib\notif::error(T_("Please set a valid way"), 'way');
			return false;
		}

		$fullname = \dash\request::post('fullname');
		if(mb_strlen($fullname) > 150)
		{
			\lib\notif::error(T_("Please set fullname less than 150 character"), 'fullname');
			return false;
		}


		$email = \dash\request::post('email');
		if(mb_strlen($email) > 90)
		{
			\lib\notif::error(T_("Please set email less than 90 character"), 'email');
			return false;
		}

		$mobile = \dash\request::post('mobile');
		if($mobile && !\dash\utility\filter::mobile($mobile))
		{
			\lib\notif::error(T_("Please set a valid mobile number"), 'mobile');
			return false;
		}

		if($mobile)
		{
			$mobile = \dash\utility\filter::mobile($mobile);
		}

		$amount = \dash\request::post('amount');
		if(!$amount || !is_numeric($amount))
		{
			\lib\notif::error(T_("Please set a valid amount number"), 'amount');
			return false;
		}

		$user_id = \lib\user::id();

		if(!\lib\user::id())
		{
			if($mobile)
			{
				$check_user_mobile = \dash\db\users::get_by_mobile($mobile);
				if(isset($check_user_mobile['id']))
				{
					$user_id = $check_user_mobile['id'];
				}
				else
				{
					if($email)
					{
						$check_user_email = \dash\db\users::get_by_email($email);
						if(isset($check_user_email['id']))
						{
							$user_id = $check_user_email['id'];
						}
						else
						{
							$signup =
							[
								'email'      => $email,
								'displayname' => $fullname,
							];
							$user_id = \dash\db\users::signup($signup);
						}
					}
					else
					{
						$signup =
						[
							'mobile'      => $mobile,
							'displayname' => $fullname,
						];
						$user_id = \dash\db\users::signup($signup);
					}
				}
			}
			elseif($email)
			{
				$check_user_email = \dash\db\users::get_by_email($email);
				if(isset($check_user_email['id']))
				{
					$user_id = $check_user_email['id'];
				}
				else
				{
					$signup =
					[
						'email'      => $email,
						'displayname' => $fullname,
					];
					$user_id = \dash\db\users::signup($signup);
				}
			}
			else
			{
				$user_id = 'unverify';
			}
		}

		$meta =
		[
			'turn_back'   => \dash\url::pwd(),
			'other_field' =>
			[
				'hazinekard' => $way,
				'niyat'      => $niyat,
				'fullname'   => $fullname,
			]
		];

		\dash\utility\payment\pay::start($user_id, 'zarinpal', \dash\request::post('amount'), $meta);
	}
}
?>
