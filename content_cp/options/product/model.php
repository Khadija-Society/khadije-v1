<?php
namespace content_cp\options\product;


class model extends \addons\content_cp\main\model
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


	public function post_product()
	{

		$post           = [];
		$post['title']  = \dash\request::post('title');
		$post['count']  = \dash\request::post('count');
		$post['amount'] = \dash\request::post('amount');
		$post['desc']   = \dash\request::post('desc');
		$post['status'] = \dash\request::post('status') ? 'enable' : 'disable' ;
		$post['type']   = 'product';

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
			\lib\app\need::edit($id, $post);
		}
		else
		{
			\lib\app\need::add($post);
		}

		if(\dash\engine\process::status())
		{
			if(\dash\request::get('edit'))
			{
				\dash\notif::ok(T_("Way successfully edited"));
			}
			else
			{
				\dash\notif::ok(T_("Way successfully added"));
			}
			\dash\redirect::pwd();
		}
	}
}
?>
