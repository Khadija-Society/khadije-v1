<?php
namespace content_cp\service\options;


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
		\dash\permission::access('cpServiceOption');
		$post           = [];
		$post['lang']  = \dash\request::post('language');
		$post['title']  = \dash\request::post('title');
		$post['count']  = \dash\request::post('count');
		$post['amount'] = \dash\request::post('amount');
		$post['desc']   = \dash\request::post('desc');
		$post['term']   = \dash\request::post('term') ? $_POST['term'] : null;
		$post['status'] = \dash\request::post('status') ? 'enable' : 'disable' ;
		$post['type']   = 'expertise';

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
			\lib\app\need::edit($id, $post, ['service' => true]);
		}
		else
		{
			\lib\app\need::add($post, ['service' => true]);
		}

		if(\dash\engine\process::status())
		{
			if(\dash\request::get('edit'))
			{
				\dash\notif::ok(T_("Way successfully edited"));
				\dash\redirect::to(\dash\url::here(). '/service/options');
			}
			else
			{
				\dash\notif::ok(T_("Way successfully added"));
				\dash\redirect::pwd();
			}
		}
	}
}
?>
