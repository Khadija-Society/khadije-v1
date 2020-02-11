<?php
namespace content_lottery\item\add;


class model
{
	public static function post()
	{

		$post =
		[
			'title'  => \dash\request::post('title'),
		];

		$result = \lib\app\syslottery::add($post);

		if(\dash\engine\process::status())
		{
			if(isset($result['id']))
			{
				\dash\redirect::to(\dash\url::this(). '/edit?id='. $result['id']. \dash\data::xTypeAnd());
			}
			else
			{
				\dash\redirect::to(\dash\url::this(). \dash\data::xTypeStart());
			}
		}

	}
}
?>