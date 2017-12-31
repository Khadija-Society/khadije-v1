<?php
namespace content_a\donate;


class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title']   = T_("Khadije Dashboard");
		$this->data->page['desc']    = $this->data->site['desc'];
		// $this->data->page['desc']    = T_("Glance at your stores and quickly navigate to stores.");
		// $this->data->page['special'] = true;

		$this->data->way_list = \lib\app\donate::way_list();

		if($amount = \lib\session::get('payment_verify_ok'))
		{
			\lib\session::set('payment_verify_ok', null);
			$this->data->payment_verify_msg = T_("Thanks for your payment");
		}

	}
}
?>
