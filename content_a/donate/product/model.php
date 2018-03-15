<?php
namespace content_a\donate\product;


class model extends \content_a\main\model
{

	public function post_donate()
	{
		if(\lib\request::post('username'))
		{
			\lib\debug::error(T_("Whate are you doing?"));
			return false;
		}

		$niyat = \lib\request::post('niyat');
		if(mb_strlen($niyat) > 150)
		{
			\lib\debug::error(T_("Please set niyat less than 150 character"), 'niyat');
			return false;
		}

		$way = \lib\request::post('way');
		if($way && !in_array($way, \lib\app\donate::way_list()))
		{
			\lib\debug::error(T_("Please set a valid way"), 'way');
			return false;
		}

		$fullname = \lib\request::post('fullname');
		if(mb_strlen($fullname) > 150)
		{
			\lib\debug::error(T_("Please set fullname less than 150 character"), 'fullname');
			return false;
		}


		$email = \lib\request::post('email');
		if(mb_strlen($email) > 90)
		{
			\lib\debug::error(T_("Please set email less than 90 character"), 'email');
			return false;
		}

		$mobile = \lib\request::post('mobile');
		if($mobile && !\lib\utility\filter::mobile($mobile))
		{
			\lib\debug::error(T_("Please set a valid mobile number"), 'mobile');
			return false;
		}

		if($mobile)
		{
			$mobile = \lib\utility\filter::mobile($mobile);
		}

		$amount = \lib\request::post('amount');
		if(!$amount || !is_numeric($amount))
		{
			\lib\debug::error(T_("Please set a valid amount number"), 'amount');
			return false;
		}

		$user_id = $this->login('id');

		if(!$this->login('id'))
		{
			if($mobile)
			{
				$check_user_mobile = \lib\db\users::get_by_mobile($mobile);
				if(isset($check_user_mobile['id']))
				{
					$user_id = $check_user_mobile['id'];
				}
				else
				{
					if($email)
					{
						$check_user_email = \lib\db\users::get_by_email($email);
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
							$user_id = \lib\db\users::signup($signup);
						}
					}
					else
					{
						$signup =
						[
							'mobile'      => $mobile,
							'displayname' => $fullname,
						];
						$user_id = \lib\db\users::signup($signup);
					}
				}
			}
			elseif($email)
			{
				$check_user_email = \lib\db\users::get_by_email($email);
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
					$user_id = \lib\db\users::signup($signup);
				}
			}
			else
			{
				$user_id = 'unverify';
			}
		}

		$meta =
		[
			'turn_back'   => \lib\url::pwd(),
			'other_field' =>
			[
				'hazinekard' => $way,
				'niyat'      => $niyat,
				'fullname'   => $fullname,
			]
		];

		\lib\utility\payment\pay::start($user_id, 'zarinpal', \lib\request::post('amount'), $meta);
	}
}
?>
