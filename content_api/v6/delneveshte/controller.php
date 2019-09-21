<?php
namespace content_api\v6\delneveshte;


class controller
{
	public static function routing()
	{
		\content_api\v6::check_appkey();

		$directory = \dash\url::directory();

		if($directory === 'v6/delneveshte')
		{

			if(!\dash\request::is('get'))
			{
				\content_api\v6::no(404);
			}

			$detail = self::delneveshte();
		}
		elseif($directory === 'v6/delneveshte/add')
		{
			if(!\dash\request::is('post'))
			{
				\content_api\v6::no(404);
			}

			$detail = self::add();
		}
		elseif($directory === 'v6/delneveshte/like')
		{
			if(!\dash\request::is('post'))
			{
				\content_api\v6::no(404);
			}

			$detail = self::like();
		}
		else
		{
			\content_api\v6::no(404);
		}

		\content_api\v6::bye($detail);
	}


	private static function delneveshte()
	{
		$new = [];
		$list = \content_delneveshte\home\view::delneveshte_list();

		if(is_array($list))
		{
			foreach ($list as $key => $value)
			{
				$temp            = [];
				$temp['id']      = isset($value['id']) ? $value['id'] : null;
				$temp['content'] = isset($value['content']) ? $value['content'] : null;
				$temp['name']    = isset($value['meta']['name']) ? $value['meta']['name'] : null;
				$temp['gender']    = isset($value['meta']['gender']) ? T_($value['meta']['gender']) : null;
				$temp['plus']    = isset($value['plus']) ? $value['plus'] : null;
				$new[]           = $temp;
			}
		}

		return $new;
	}


	private static function like()
	{
		$result = \content_delneveshte\home\model::like_delneveshte();

		if($result)
		{
			\dash\notif::ok(T_("Your like was saved"));
		}

		return $result;
	}


	private static function add()
	{
		$result = \content_delneveshte\home\model::add_delneveshte();

		if($result)
		{
			\dash\notif::ok(T_("Your message was saved"));
		}
		// desc
		// mobile
		// switchGender : male, female
		return $result;
	}

}
?>