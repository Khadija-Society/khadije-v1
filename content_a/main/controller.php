<?php
namespace content_a\main;


class controller extends \mvc\controller
{
	public function repository()
	{
		if(!\lib\user::login())
		{
			\lib\redirect::to(\dash\url::base(). '/enter/signup?referer='. \dash\url::pwd());
			return;
		}
	}

	public function check_trip_id($_type = 'family')
	{
		$trip = \lib\request::get('trip');

		if(!$trip || !ctype_digit($trip) || $trip == '')
		{
			\lib\header::status(403, T_("Trip id not found"));
		}

		$check_valid_trip = \lib\db\travels::get(['id' => $trip, 'type' => $_type, 'user_id' => \lib\user::id(), 'limit' => 1]);

		if(!isset($check_valid_trip['id']))
		{
			\lib\header::status(403, T_("Invalid trip id"));
		}

		// if status of trip is not awatign redirect to list of travel
		if(isset($check_valid_trip['status']) && $check_valid_trip['status'] === 'draft')
		{
			// no problem to edit it
		}
		else
		{
			\lib\header::status(403, T_("Your trip is not draft. can not edit it"));
		}
	}

	public function check_service_id()
	{
		$id = \lib\request::get('id');

		if(!$id || !ctype_digit($id) || $id == '')
		{
			\lib\header::status(403, T_("Service id not found"));
		}

		$check_valid_id = \lib\db\services::get(['id' => $id, 'user_id' => \lib\user::id(), 'limit' => 1]);

		if(!isset($check_valid_id['id']))
		{
			\lib\header::status(403, T_("Invalid service id"));
		}

		// if status of id is not awatign redirect to list of travel
		if(isset($check_valid_id['status']) && $check_valid_id['status'] === 'draft')
		{
			// no problem to edit it
		}
		else
		{
			\lib\header::status(403, T_("Your service is not draft. can not edit it"));
		}
	}
}
?>
