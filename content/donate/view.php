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

		if($amount = \lib\session::get('payment_verify_ok'))
		{
			\lib\session::set('payment_verify_ok', null);
			$this->data->payment_verify_msg = T_("Thanks for your payment");
		}
	}
}
?>