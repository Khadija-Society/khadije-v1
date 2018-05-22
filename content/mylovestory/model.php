<?php
namespace content\mylovestory;


class model
{
	public static function pay_before()
	{
		$pay_before = \dash\user::detail('bookmylovestory');
		if(!$pay_before)
		{
			\dash\user::refresh();
			$pay_before = \dash\user::detail('bookmylovestory');
		}
		return $pay_before ? true : false;
	}


	public static function post()
	{
		$book_path = __DIR__.'/mylovestory.pdf';

		if(\dash\request::post('pay'))
		{
			if(!self::pay_before())
			{
				if(!\dash\user::login())
				{
					\dash\redirect::to(\dash\url::base(). '/enter?referer='. \dash\url::pwd());
				}

				$meta =
				[
					'turn_back' => \dash\url::pwd(),
					'other_field' =>
					[
						'hazinekard' => 'mylovestory',
						'niyat'      => null,
						'fullname'   => \dash\user::detail('displayname'),
						'donate'     => 'book',
						'doners'     => null,
					]
				];

				$bank = 'asanpardakht';

				if(\dash\url::isLocal())
				{
					$bank = 'payir';
				}

				\dash\utility\payment\pay::start(\dash\user::id(), $bank, 3000, $meta);
			}
			else
			{
				\dash\redirect::to(\dash\url::this().'?download=1');
			}

		}
		elseif(\dash\request::post('download'))
		{
			if(self::pay_before())
			{
				\dash\redirect::to(\dash\url::this().'?download=1');
			}
			else
			{
				\dash\notif::error(T_("Please pay amount and try to download"));
			}

		}
	}
}
?>