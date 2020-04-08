<?php
namespace content_lottery\item\required;


class model
{
	public static function post()
	{

		$post =
		[

			// 'firstname'    => \dash\request::post('firstname') ? true : false,
			// 'lastname'     => \dash\request::post('lastname') ? true : false,
			// 'nationalcode' => \dash\request::post('nationalcode') ? true : false,
			// 'mobile'       => \dash\request::post('mobile') ? true : false,
			'father'          => \dash\request::post('father') ? true : false,
			// 'gender'       => \dash\request::post('gender') ? true : false,
			'marital'         => \dash\request::post('marital') ? true : false,
			'desc'            => \dash\request::post('desc') ? true : false,
			'birthdate'       => \dash\request::post('birthdate') ? true : false,
			'phone'           => \dash\request::post('phone') ? true : false,
			'city'            => \dash\request::post('city') ? true : false,
			'address'         => \dash\request::post('address') ? true : false,
			'education'       => \dash\request::post('education') ? true : false,
			'videofile'       => \dash\request::post('videofile') ? true : false,
			'imagefile'       => \dash\request::post('imagefile') ? true : false,

			'inquiry'         => \dash\request::post('inquiry') ? true : false,
			'showstats'       => \dash\request::post('showstats') ? true : false,
		];


		$post['requiredfield'] = json_encode($post, JSON_UNESCAPED_UNICODE);


		\lib\app\syslottery::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
			\dash\redirect::to(\dash\url::here(). '/item'. \dash\data::xTypeStart());
		}

	}
}
?>