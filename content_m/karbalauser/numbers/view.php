<?php
namespace content_m\karbalauser\numbers;


class view
{
	public static function config()
	{
		\dash\permission::access('cpKarbalaUserCountAdd');


		\dash\data::page_pictogram('plus');

		\dash\data::page_title("تعداد افراد مشرف شده خارج از سیستم");

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));


		$get_option_record =
		[
			'cat'   => 'stat_place_manual',
		];

		$result = \dash\db\options::get($get_option_record);
		$new_result = [];
		if(is_array($result))
		{
			foreach ($result as $key => $value)
			{
				$meta = [];
				if(isset($value['meta']) && is_string($value['meta']))
				{
					$meta = json_decode($value['meta'], true) ;
				}

				$temp           = [];
				$temp['id']     = isset($value['id']) ? $value['id'] : null;
				$temp['city']   = isset($meta['city']) ? T_($meta['city']) : null;
				$temp['status'] = isset($meta['status']) ? T_(ucfirst($meta['status'])) : null;
				$temp['count']  = isset($meta['count']) ? $meta['count'] : null;
				$temp['desc']   = isset($meta['desc']) ? $meta['desc'] : null;

				$new_result[] = $temp;
			}
		}
		\dash\data::manualResult($new_result);


	}
}
?>
