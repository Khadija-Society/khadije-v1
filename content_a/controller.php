<?php
namespace content_a;

class controller
{
	public static function routing()
	{
		if(\dash\url::module() === 'exportcurlkarbalausers' && \dash\request::is('post'))
		{
			\content_cms\userkarbala\home\model::verify();
			\dash\code::boom();
		}

		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::kingdom(). '/enter?referer='. \dash\url::pwd());
			return;
		}

		if(!\dash\session::get('CheckisAgentServant'))
		{
			$check = \lib\db\servant::get(['agent_servant.user_id' => \dash\user::id(), 'agent_servant.status' => 'enable', 'limit' => 1]);
			\dash\session::set('CheckisAgentServant', true);
			if($check)
			{
				\dash\session::set('isAgentServant', true);
			}
		}

		\dash\data::isAgentServant(\dash\session::get('isAgentServant'));
	}


	public static function check_trip_id($_type = 'family')
	{
		$trip = \dash\request::get('trip');
		if(!$trip || !ctype_digit($trip) || $trip == '')
		{
			\dash\header::status(403, T_("Trip id not found"));
		}

		$check_valid_trip = \lib\db\travels::get(['id' => $trip, 'type' => $_type, 'user_id' => \dash\user::id(), 'limit' => 1]);

		if(!isset($check_valid_trip['id']))
		{
			\dash\header::status(403, T_("Invalid trip id"));
		}

		// if status of trip is not awatign redirect to list of travel
		if(isset($check_valid_trip['status']) && $check_valid_trip['status'] === 'draft')
		{
			// no problem to edit it
		}
		else
		{
			\dash\header::status(403, T_("Your trip is not draft. can not edit it"));
		}

		\dash\data::tripDetail($check_valid_trip);
	}

	public static function check_service_id()
	{
		$id = \dash\request::get('id');

		if(!$id || !ctype_digit($id) || $id == '')
		{
			\dash\header::status(403, T_("Service id not found"));
		}

		$check_valid_id = \lib\db\services::get(['id' => $id, 'user_id' => \dash\user::id(), 'limit' => 1]);

		if(!isset($check_valid_id['id']))
		{
			\dash\header::status(403, T_("Invalid service id"));
		}

		// if status of id is not awatign redirect to list of travel
		if(isset($check_valid_id['status']) && $check_valid_id['status'] === 'draft')
		{
			// no problem to edit it
		}
		else
		{
			\dash\header::status(403, T_("Your service is not draft. can not edit it"));
		}
	}
}
?>