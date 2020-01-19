<?php
namespace content_agent\servant\sortlist;


class model
{
	public static function post()
	{
		if(\dash\request::post('reject') === 'reject' && \dash\request::post('servant_id'))
		{
			$servant_detail = \lib\app\servant::get(\dash\request::post('servant_id'));
			if(!$servant_detail)
			{
				\dash\notif::error(T_("Data not found"));
				return false;
			}

			if(!array_key_exists('reject_count', $servant_detail) || !array_key_exists('reject_date', $servant_detail))
			{
				return null;
			}

			$update = [];
			if(!$servant_detail['reject_count'])
			{
				$update['reject_count'] = 1;
			}
			else
			{
				$update['reject_count'] = intval($servant_detail['reject_count']) + 1;
				$update['reject_date'] = date("Y-m-d H:i:s");
			}

			\lib\db\servant::update($update, \dash\coding::decode(\dash\request::post('servant_id')));

			\dash\notif::ok(T_("Data saved"));

			\dash\redirect::pwd();




		}
	}
}
?>