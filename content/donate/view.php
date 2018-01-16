<?php
namespace content\donate;


class view extends \mvc\view
{
	function config()
	{
		$this->data->page['title'] = T_("Donate");
		$this->data->page['desc']  = T_("Pay your donate online with below form");


		$this->data->bodyclass = 'unselectable vflex';
		$this->data->way_list  = \lib\app\donate::way_list();
		$this->data->donateArchive = \lib\db\mytransactions::user_transaction('cash');


		if(\lib\session::get('payment_request_start'))
		{
			if(\lib\utility\payment\verify::get_status())
			{
				$this->data->payment_verify_msg_true = true;
				$this->data->payment_verify_msg = T_("Thanks for your payment");
				\lib\app\donate::sms_success(\lib\utility\payment\verify::get_amount());
			}
			else
			{
				$this->data->payment_verify_msg_true = false;
				$this->data->payment_verify_msg = T_("Payment unsuccessfull");
			}

			\lib\utility\payment\verify::clear_session();
		}
	}
}
?>