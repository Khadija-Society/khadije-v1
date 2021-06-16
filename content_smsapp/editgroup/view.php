<?php
namespace content_smsapp\editgroup;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');
		\dash\data::page_title(T_("Edit sms group"));
		\dash\data::page_desc(T_("You cat set some group for sms"));

		\dash\data::badge_link(\dash\url::here(). '/settings' . \dash\data::platoonGet());
		\dash\data::badge_text(T_('Settings'));


		if(\dash\data::blockMode() || \dash\data::secretMode())
		{

			$args =
			[
				'pagenation' => false,
				'type'       => 'number',
				'platoon' => \lib\app\platoon\tools::get_index_locked(),
				'group_id'   => \dash\coding::decode(\dash\data::myId()),
			];


			$numbers = \lib\app\smsgroupfilter::list(null, $args);

			\dash\data::myNumbers($numbers);

		}

		$args =
		[
			'pagenation' => false,
			'type'       => 'analyze',
			'platoon' => \lib\app\platoon\tools::get_index_locked(),
			'group_id'   => \dash\coding::decode(\dash\data::myId()),
		];


		$tagList = \lib\app\smsgroupfilter::list(null, $args);

		if($tagList && is_array($tagList))
		{
			\dash\data::tagList($tagList);
			\dash\data::stringTagList(implode(',', array_column($tagList, 'text')));
		}


		$myLastSort = 1;
		$args =
		[
			'pagenation' => false,
			'type'       => 'answer',
			'platoon' => \lib\app\platoon\tools::get_index_locked(),
			'order'      => 'asc',
			'sort'       => 'sort',
			'group_id'   => \dash\coding::decode(\dash\data::myId()),
		];

		$answerList = \lib\app\smsgroupfilter::list(null, $args);

		\dash\data::answerList($answerList);

		if(is_array($answerList))
		{
			$sort_list = array_column($answerList, 'sort');

			if($sort_list)
			{
				$myLastSort = max($sort_list) + 1;
			}

		}


		if(\dash\request::get('aid'))
		{
			$loadAnswer = \lib\app\smsgroupfilter::get(\dash\request::get('aid'));
			\dash\data::answerDataRow($loadAnswer);

			$myLastSort = a($loadAnswer, 'sort');


		}

		\dash\data::myLastSort($myLastSort);


	}
}
?>
