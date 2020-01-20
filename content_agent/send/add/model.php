<?php
namespace content_agent\send\add;


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

		$post =
		[
			'city'        => \dash\request::get('city'),

			'place_id'    => \dash\request::get('place'),

			'title'       => \dash\request::post('title'),

			'starttime'   => \dash\request::post('starttime'),
			'endtime'     => \dash\request::post('endtime'),

			'startdate'   => \dash\request::post('startdate'),
			'enddate'     => \dash\request::post('enddate'),


			'mobile'      => \dash\request::post('memberTl'),
			'gender'      => \dash\request::post('memberGender'),
			'displayname' => \dash\request::post('memberN'),

			'clergy'      => \dash\request::post('clergy'),
			'admin'       => \dash\request::post('admin'),
			'adminoffice' => \dash\request::post('adminoffice'),
			'missionary'  => \dash\request::post('missionary'),
			'servant'     => \dash\request::post('servant'),
			'servant2'     => \dash\request::post('servant2'),
			'maddah'      => \dash\request::post('maddah_id'),
			'nazer'       => \dash\request::post('nazer_id'),
			'khadem'      => \dash\request::post('khadem_id'),
			'khadem2'     => \dash\request::post('khadem2_id'),
		];

		\lib\app\send::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::this(). \dash\data::xCityStart());
		}

	}
}
?>