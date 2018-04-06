<?php
namespace content\doners;

class view extends \mvc\view
{
	function config()
	{
		$this->data->page['title'] = T_("Doners");
		$this->data->page['desc']  = T_("List of our last doners");


		$this->data->bodyclass = 'unselectable';
		$this->data->way_list  = \lib\app\donate::way_list();

		$this->data->DonersList = \lib\db\mytransactions::transaction_list();


		if(\dash\session::get('payment_request_start'))
		{
			if(\dash\utility\payment\verify::get_status())
			{
				$amount = \dash\utility\payment\verify::get_amount();
				$this->data->payment_verify_msg_true = true;
				$this->data->payment_verify_msg = T_("Thanks for your holy payment, :amount sucsessfully recived", ['amount' => \dash\utility\human::fitNumber($amount)]);
				\lib\app\donate::sms_success($amount);
			}
			else
			{
				$this->data->payment_verify_msg_true = false;
				$this->data->payment_verify_msg = T_("Payment unsuccessfull");
			}

			\dash\utility\payment\verify::clear_session();
		}

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>