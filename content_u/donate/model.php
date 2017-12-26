<?php
namespace content_u\donate;


class model extends \content_u\main\model
{
	private static function getPost()
	{
		$args =
		[
			'mobile'    => \lib\utility::post('mobile'),
			'firstname' => \lib\utility::post('firstname'),
			'lastname'  => \lib\utility::post('lastname'),
			'email'     => \lib\utility::post('email'),
			'niyat'     => \lib\utility::post('niyat'),
			'amount'    => \lib\utility::post('amount'),
			'way'       => \lib\utility::post('way'),
		];
		return $args;
	}


	public function post_donate()
	{
		if(\lib\utility::post('username'))
		{
			\lib\debug::error(T_("Whate are you doing?"));
			return false;
		}

		$user_id = $this->login('id');

		if(!$this->login('id'))
		{
			if(\lib\utility::post('mobile') && \lib\utility\filter::mobile(\lib\utility::post('mobile')))
			{
				$mobile = \lib\utility\filter::mobile(\lib\utility::post('mobile'));
				$check_user = \lib\db\users::get_by_mobile($mobile);
				if(isset($check_user['id']))
				{
					$user_id = $check_user['id'];
				}
				else
				{
					$user_id = 'unverify';
				}
			}
			else
			{
				$user_id = 'unverify';
			}
		}

		$niyat = \lib\utility::post('niyat');
		if(mb_strlen($niyat) > 150)
		{
			\lib\debug::error(T_("Please set niyat less than 150 character"), 'niyat');
			return false;
		}

		$way = \lib\utility::post('way');
		if(mb_strlen($way) > 150)
		{
			\lib\debug::error(T_("Please set way less than 150 character"), 'way');
			return false;
		}

		$meta = ['turn_back' => $this->url('full'), 'other_field' => ['hazinekard' => $way, 'niyat' => $niyat]];

		\lib\utility\payment\pay::start($user_id, 'zarinpal', \lib\utility::post('amount'), $meta);
	}
}
?>
