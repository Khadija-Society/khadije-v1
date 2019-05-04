<?php
namespace content_m\trip\setting;


class model
{


	public static function post()
	{
		if(\dash\request::post('setdatecreated') && \dash\request::post('datecreated'))
		{
			$datecreated = \dash\request::post('datecreated');
			$datecreated = \dash\utility\convert::to_en_number($datecreated);
			if($datecreated && strtotime($datecreated) === false)
			{
				\dash\notif::error(T_("Invalid datecreated"), 'datecreated');
				return false;
			}

			if(\dash\utility\jdate::is_jalali($datecreated))
			{
				$datecreated = \dash\utility\jdate::to_gregorian($datecreated);
			}

			$olddatecreated = \dash\request::post('olddatecreated');

			if($datecreated)
			{
				$datecreated = date("Y-m-d", strtotime($datecreated));
				$datecreated.= ' '. date("H:i:s");
				\lib\db\travels::update(['datecreated' => $datecreated], \dash\request::get('id'));
				\dash\log::set('datecreatedTripChange', ['code' => \dash\request::get('id'), 'new' => $datecreated, 'old' => $olddatecreated]);
				\dash\notif::ok(T_("Date saved"));
				\dash\redirect::pwd();
			}
			else
			{
				$datecreated = null;
			}
			return;
		}

		if(\dash\request::post('edit_travel') === 'edit_travel')
		{
			$start_date = \dash\request::post('startdate');
			$start_date = \dash\utility\convert::to_en_number($start_date);
			if($start_date && strtotime($start_date) === false)
			{
				\dash\notif::error(T_("Invalid start_date"), 'start_date');
				return false;
			}

			if(\dash\utility\jdate::is_jalali($start_date))
			{
				$start_date = \dash\utility\jdate::to_gregorian($start_date);
			}

			if($start_date)
			{
				$start_date = date("Y-m-d", strtotime($start_date));
			}
			else
			{
				$start_date = null;
			}

			$end_date   = \dash\request::post('enddate');
			$end_date   = \dash\utility\convert::to_en_number($end_date);
			if($end_date && strtotime($end_date) === false)
			{
				\dash\notif::error(T_("Invalid end_date"), 'end_date');
				return false;
			}

			if(\dash\utility\jdate::is_jalali($end_date))
			{
				$end_date = \dash\utility\jdate::to_gregorian($end_date);
			}

			if($end_date)
			{
				$end_date = date("Y-m-d", strtotime($end_date));
			}
			else
			{
				$end_date = null;
			}


			$desc       = \dash\request::post('desc');

			if(mb_strlen($desc) > 500)
			{
				\dash\notif::error(T_("Maximum input for desc"), 'desc');
				return false;
			}


			$update              = [];
			$update['startdate'] = $start_date;
			$update['enddate']   = $end_date;
			$update['desc']      = $desc;

			\lib\db\travels::update($update, \dash\request::get('id'));
			\dash\log::set('updatePartnerGroupTrip', ['code' => \dash\request::get('id'), 'update' => $update]);


			\dash\notif::ok(T_("The travel updated"));

			\dash\redirect::pwd();

		}

	}
}
?>
