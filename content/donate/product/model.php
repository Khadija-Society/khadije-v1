<?php
namespace content\donate\product;

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
		];

		$allPost         = \dash\request::post();
		$productList     = [];
		$count_product   = 0;
		$element_product = [];
		foreach ($allPost as $key => $value)
		{
			if(substr($key, 0, 8) === 'product_')
			{
				$element_product[]            = $key;
				$productList[substr($key, 8)] = $value;
				$count_product                += intval($value);
			}
		}

		if(!$count_product)
		{
			\dash\notif::error(T_("Please set product count to pay donate"), ['element' => $element_product]);
			return false;
		}

		$args['product'] = $productList;

		\lib\app\donate::add($args);


	}
}
?>