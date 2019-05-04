<?php
namespace content_m\duplicatequery;


class view
{
	public static function config()
	{
		if(!\dash\permission::supervisor())
		{
			\dash\header::status(403);
		}

		$query =
		"
		SELECT
		(SELECT COUNT(*) FROM travels WHERE travels.user_id = users.id ) AS travels_count,
		(SELECT COUNT(*) FROM transactions WHERE transactions.user_id = users.id ) AS transactions_count,
		(SELECT COUNT(*) FROM services WHERE services.user_id = users.id ) AS services_count,
		(SELECT COUNT(*) FROM travelusers WHERE travelusers.user_id = users.id ) AS travelusers_count,
		(SELECT COUNT(*) FROM users as mU WHERE mU.mobile = users.mobile ) AS mobile_count,
		users.*

		FROM users
		WHERE users.status = 'awaiting' AND users.datemodified IS NULL
		And 'travels_count' = 0
		And 'transactions_count' = 0
		And 'services_count' = 0
		And 'travelusers_count' = 0
		And (SELECT COUNT(*) FROM users as mU WHERE mU.mobile = users.mobile ) > 1


		ORDER BY `mobile_count` DESC
		";
		$result = \dash\db::get($query);
		\dash\data::dataTable($result);

		if(\dash\request::get('run') === 'run')
		{
			foreach ($result as $key => $value)
			{
				$removed = \dash\app\user::delete_user($value['id']);
			}
		}

	}
}
?>
