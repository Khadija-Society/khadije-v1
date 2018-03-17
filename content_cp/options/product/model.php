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
		if(\lib\utility::files('thumb'))
		{
			$uploaded_file = \lib\app\file::upload(['debug' => false, 'upload_name' => 'thumb']);

			if(isset($uploaded_file['url']))
			{
				return $uploaded_file['url'];
			}
			// if in upload have error return
			if(!\lib\debug::$status)
			{
				return false;
			}
		}
		return null;
	}


	public function post_product()
	{

		$post           = [];
		$post['title']  = \lib\request::post('title');
		$post['count']  = \lib\request::post('count');
		$post['amount'] = \lib\request::post('amount');
		$post['desc']   = \lib\request::post('desc');
		$post['status'] = \lib\request::post('status') ? 'enable' : 'disable' ;
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

		if(\lib\request::get('edit'))
		{
			$id = \lib\request::get('edit');
			\lib\app\need::edit($id, $post);
		}
		else
		{
			\lib\app\need::add($post);
		}

		if(\lib\debug::$status)
		{
			if(\lib\request::get('edit'))
			{
				\lib\debug::true(T_("Way successfully edited"));
			}
			else
			{
				\lib\debug::true(T_("Way successfully added"));
			}
			\lib\redirect::pwd();
		}
	}
}
?>
