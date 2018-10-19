<?php
namespace content_cp\representation\options;


class model
{
	/**
	 * Uploads a thumb.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function upload_thumb()
	{
		if(\dash\request::files('thumb'))
		{
			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'thumb']);

			if(isset($uploaded_file['url']))
			{
				return $uploaded_file['url'];
			}
			// if in upload have error return
			if(!\dash\engine\process::status())
			{
				return false;
			}
		}
		return null;
	}


	public static function post()
	{
		if(\dash\request::post('representation') === 'alldone')
		{
			\dash\permission::access('cpRepresentationSetAllDone');
			$id      = \dash\request::get('edit');
			$post_id = \dash\request::post('id');

			if($id !== $post_id)
			{
				\dash\notif::error(T_("Dont!"));
				return false;
			}

			$get_place = \lib\db\needs::get(['id' => $id, 'limit' => 1]);
			if(!isset($get_place['title']))
			{
				\dash\notif::error(T_("Invalid place id"));
				return false;
			}

			$update           = [];
			$update['status'] = 'accept';

			$args            =
			[
				'services.type'       => 'representation',
				'services.status'     => 'awaiting',
				'services.expert'     => $get_place['title'],
				'pagenation' => false,
			];

			$where            =
			[
				'type'       => 'representation',
				'status'     => 'awaiting',
				'expert'     => $get_place['title'],
			];

			$count            = \lib\db\services::search(null, $args);


			if($count)
			{
				\lib\db\services::update_where($update, $where);

				$mobile = array_column($count, 'mobile');
				if(is_array($mobile))
				{
					$msg = T_("Your representation request for :place is done.", ['place' => $get_place['title']]);
					\dash\utility\sms::send_array($mobile, $msg);
				}

				\dash\notif::info(T_("Allahouma sali ala mohamed wa ali muhammad"));
				\dash\notif::ok(T_(":count request status changed", ['count' => \dash\utility\human::fitNumber(count($count))]));
				return true;
			}
			else
			{
				\dash\notif::warn(T_("No awaiting request found!"));
				return false;
			}

		}

		\dash\permission::access('cpRepresentationOption');

		$post           = [];
		$post['title']  = \dash\request::post('title');
		$post['lang']  = \dash\request::post('language');
		$post['count']  = null;
		$post['amount'] = null;
		$post['desc']   = \dash\request::post('desc');
		$post['term']   = \dash\request::post('term') ? $_POST['term'] : null;
		$post['status'] = \dash\request::post('status') ? 'enable' : 'disable' ;
		$post['type']   = 'representation';

		$file = self::upload_thumb();
		if($file === false)
		{
			return false;
		}

		if($file)
		{
			$post['fileurl'] = $file;
		}

		if(\dash\request::get('edit'))
		{
			$id = \dash\request::get('edit');
			\lib\app\need::edit($id, $post, ['is_other' => true]);
		}
		else
		{
			\lib\app\need::add($post, ['is_other' => true]);
		}

		if(\dash\engine\process::status())
		{
			if(\dash\request::get('edit'))
			{
				\dash\notif::ok(T_("Representation successfully edited"));
				\dash\redirect::to(\dash\url::here(). '/representation/options');
			}
			else
			{
				\dash\notif::ok(T_("Representation successfully added"));
				\dash\redirect::pwd();
			}
		}
	}
}
?>
