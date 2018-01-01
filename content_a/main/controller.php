<?php
namespace content_a\main;


class controller extends \mvc\controller
{
	public function repository()
	{
		if(!$this->login())
		{
			$this->redirector($this->url('base'). '/enter/signup')->redirect();
			return;
		}
	}

	public function check_trip_id()
	{
		$trip = \lib\utility::get('trip');

		if(!$trip || !ctype_digit($trip) || $trip == '')
		{
			\lib\error::access(T_("Trip id not found"));
		}

		$check_valid_trip = \lib\db\travels::get(['id' => $trip, 'user_id' => \lib\user::id(), 'limit' => 1]);

		if(!isset($check_valid_trip['id']))
		{
			\lib\error::access(T_("Invalid trip id"));
		}

	}
}
?>
