<?php
namespace content_a\main;


class controller extends \mvc\controller
{
	public function repository()
	{
		if(!$this->login())
		{
			$this->redirector($this->url('base'). '/enter/signup?referer='. \lib\url::pwd())->redirect();
			return;
		}
	}

	public function check_trip_id($_type = 'family')
	{
		$trip = \lib\utility::get('trip');

		if(!$trip || !ctype_digit($trip) || $trip == '')
		{
			\lib\error::access(T_("Trip id not found"));
		}

		$check_valid_trip = \lib\db\travels::get(['id' => $trip, 'type' => $_type, 'user_id' => \lib\user::id(), 'limit' => 1]);

		if(!isset($check_valid_trip['id']))
		{
			\lib\error::access(T_("Invalid trip id"));
		}

		// if status of trip is not awatign redirect to list of travel
		if(isset($check_valid_trip['status']) && $check_valid_trip['status'] === 'draft')
		{
			// no problem to edit it
		}
		else
		{
			\lib\error::access(T_("Your trip is not draft. can not edit it"));
		}
	}

	public function check_service_id()
	{
		$id = \lib\utility::get('id');

		if(!$id || !ctype_digit($id) || $id == '')
		{
			\lib\error::access(T_("Service id not found"));
		}

		$check_valid_id = \lib\db\services::get(['id' => $id, 'user_id' => \lib\user::id(), 'limit' => 1]);

		if(!isset($check_valid_id['id']))
		{
			\lib\error::access(T_("Invalid service id"));
		}

		// if status of id is not awatign redirect to list of travel
		if(isset($check_valid_id['status']) && $check_valid_id['status'] === 'draft')
		{
			// no problem to edit it
		}
		else
		{
			\lib\error::access(T_("Your service is not draft. can not edit it"));
		}
	}
}
?>
