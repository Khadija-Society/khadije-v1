<?php
namespace content\donate;

class model
{
	public static function post()
	{
		$args =
		[
			'username'   => \dash\request::post('username'),
			'bank'       => mb_strtolower(\dash\request::post('bank')),
			'niyat'      => \dash\request::post('niyat'),
			'way'        => \dash\request::post('way'),
			'fullname'   => \dash\request::post('fullname'),
			'email'      => \dash\request::post('email'),
			'isAndroid'  => \dash\request::post('isAndroid'),
			'mobile'     => \dash\request::post('mobile'),
			'amount'     => intval(\dash\request::post('amount')) / 10,
			'doners'     => \dash\request::post('doners') === 'yes' ? 1 : 0,
			'wayopt'     => \dash\request::post('wayOpt'),
			'totalcount' => \dash\request::post('totalCount'),
			'childname' => \dash\request::post('childname'),
			'fathername' => \dash\request::post('fathername'),
		];

		if(strpos($args['way'], 'عقیقه') !== false)
		{
			if(!$args['childname'])
			{
				\dash\notif::error("برای اجرای عقیقه لطفا نام فرزند را وارد کنید", 'childname');
				return false;
			}

			if(!$args['fathername'])
			{
				\dash\notif::error("برای اجرای عقیقه لطفا نام پدر را وارد کنید", 'fathername');
				return false;
			}

			if(mb_strlen($args['childname']) > 50)
			{
				\dash\notif::error("لطفا نام فرزند را زیر ۵۰ حرف وارد کنید", 'childname');
				return false;
			}

			if(mb_strlen($args['fathername']) > 50)
			{
				\dash\notif::error("لطفا نام پدر را زیر ۵۰ حرف وارد کنید", 'fathername');
				return false;
			}
		}


		$redirect = false;
		if(\dash\permission::check('donateManualPay'))
		{
			$redirect = true;
			$args['manuall'] = \dash\request::post('manualPay');
		}

		\lib\app\donate::add($args);

		if($redirect)
		{
			\dash\redirect::pwd();
		}
	}
}
?>