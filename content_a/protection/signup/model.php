<?php
namespace content_a\protection\signup;


class model
{
	public static function post()
	{
		if(\dash\request::post('register') === 'register')
		{
			$post =
			[
				'occasion_id' => \dash\request::get('id')
			];

			$result = \lib\app\protectionagentoccasion::add($post);

			if(isset($result['id']))
			{
				\dash\redirect::to(\dash\url::this(). '/detail?id='. $result['id']);
			}

		}

	}
}
?>
