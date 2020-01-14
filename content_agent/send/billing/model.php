<?php
namespace content_agent\send\billing;


class model
{
	public static function post()
	{

		$paybank   = \dash\request::post('paybank');
		$paytype   = \dash\request::post('paytype');
		$paynumber = \dash\request::post('paynumber');

        $bank = \dash\request::post('bank');
        if($bank == 'otherbank')
        {
        }
        else
        {
        	$split = explode('_', $bank);
        	if(count($split) === 3)
        	{
	        	if(isset($split[0]))
	        	{
	        		$paybank  = $split[0];
	        	}

	        	if(isset($split[1]))
	        	{
	        		$paytype  = $split[1];
	        	}

	        	if(isset($split[2]))
	        	{
	        		$paynumber  = $split[2];
	        	}
        	}

        }

		$send_id = \dash\coding::decode(\dash\request::get('id'));


		$update_send =
		[
			'payamount' => \dash\request::post('payamount'),
			'paydate'   => \dash\request::post('paydate'),
			'gift'      => \dash\request::post('desc'),

		];
		if($paybank !== false)
		{
			$update_send['paybank'] = $paybank;
		}

		if($paytype !== false)
		{
			$update_send['paytype'] = $paytype;
		}

		if($paynumber !== false)
		{
			$update_send['paynumber'] = $paynumber;
		}

		\lib\app\send::edit($update_send, \dash\request::get('id'));


		if(\dash\engine\process::status())
		{

			\dash\redirect::to(\dash\url::pwd());
		}
	}
}
?>