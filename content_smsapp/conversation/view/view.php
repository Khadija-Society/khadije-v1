<?php
namespace content_smsapp\conversation\view;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('chat');

		\dash\data::page_title('نمایش لیست گفتگو با '. \dash\fit::text(\dash\data::myMobile()));

		\dash\data::badge_link(\dash\url::this(). \dash\data::platoonGet());
		\dash\data::badge_text(T_('Back'));


		$filterArray = [];
		$countArgs   = [];

		$args =
		[
			'order'      => \dash\request::get('order'),
			'sort'       => \dash\request::get('sort'),
			'limit'      => 100,
			'fromnumber' => \dash\data::myMobile(),
		];

		$q = \dash\request::get('q');

		$list = \lib\app\conversation\search::view($q, $args);


		// var_dump($list);exit;

		if(!is_array($list))
		{
			$list = [];
		}
		$load_all_group_keyword = [];
		$all_group_id     = array_column($list, 'group_id');
		$all_recommend_id = array_column($list, 'recommend_id');
		$all_group_id     = array_merge($all_group_id, $all_recommend_id);
		$all_group_id     = array_filter($all_group_id);
		$all_group_id     = array_unique($all_group_id);
		if($all_group_id)
		{
			$all_group_id = array_map('intval', $all_group_id);
			$all_group_id = implode(',', $all_group_id);
			$load_all_group = \lib\db\smsgroup::get(['id' => ['IN', "($all_group_id)"]]);
			if(!is_array($load_all_group))
			{
				$load_all_group = [];
			}

			// $load_all_group = array_map(['\\lib\\app\\smsgroup', 'ready'], $load_all_group);
			$load_all_group = array_combine(array_column($load_all_group, 'id'), $load_all_group);
			\dash\data::allGroup($load_all_group);

			$load_all_group_keyword = \lib\db\smsgroupfilter::get(['group_id' => ['IN', "($all_group_id)"], 'type' => 'analyze']);
		}

		$all_group_keyword = [];
		foreach ($load_all_group_keyword as $key => $value)
		{
			if(!isset($value['group_id']))
			{
				continue;
			}

			if(!isset($all_group_keyword[$value['group_id']]))
			{
				$all_group_keyword[$value['group_id']] = [];
			}

			$all_group_keyword[$value['group_id']][] = $value['text'];
		}

		if(a($list, 0, 'answertext'))
		{
			\dash\data::lockAnswer(true);
		}


		foreach ($list as $key => $value)
		{
			if(isset($value['group_id']) && isset($all_group_keyword[$value['group_id']]))
			{
				foreach ($all_group_keyword[$value['group_id']] as $word)
				{
					$red_word = '<span class="fc-red txtB">'. $word. '</span>';
					$list[$key]['text'] = str_replace($word, $red_word, $list[$key]['text']);
				}
			}
		}

		\dash\data::dataTable($list);

		$need_archive = array_column($list, 'conversation_answered');
		$need_archive = array_unique($need_archive);
		// $need_archive = array_filter($need_archive);
		$need_archive = array_values($need_archive);

		if(in_array(null, $need_archive))
		{
			\dash\data::needArchive(true);
		}

		$smsgroup = \lib\db\smsgroup::get_answering_group(\lib\app\platoon\tools::get_index_locked());

		\dash\data::groupList($smsgroup);

		$answers = \lib\db\smsgroupfilter::get(['type' => 'answer']);
		$dataAnswer = [];
		if(is_array($answers))
		{
			foreach ($answers as $key => $value)
			{
				if(!isset($dataAnswer[$value['group_id']]))
				{
					$dataAnswer[$value['group_id']] = [];
				}

				$dataAnswer[$value['group_id']][] = $value;
			}
		}

		\dash\data::dataAnswer($dataAnswer);


		$currentUser = \lib\app\conversation\search::load_current_user($list);
		\dash\data::currentUser($currentUser);


		$block_group_id = \content_smsapp\editgroup\controller::block_group_id(true);
		$secret_group_id = \content_smsapp\editgroup\controller::secret_group_id(true);


		$find_blocked = \lib\db\smsgroupfilter::get(['type' => 'number', 'number' => \dash\data::myMobile(), 'group_id' => ['IN', "($block_group_id, $secret_group_id)"]]);
		if(!is_array($find_blocked))
		{
			$find_blocked = [];
		}

		foreach ($find_blocked as $key => $value)
		{
			if(isset($value['group_id']))
			{
				if(floatval($value['group_id']) === floatval($block_group_id))
				{
					\dash\data::isBlock(\lib\app\smsgroupfilter::ready($value));
				}
				elseif(floatval($value['group_id']) === floatval($secret_group_id))
				{
					\dash\data::isSecred(\lib\app\smsgroupfilter::ready($value));

				}
			}
		}
	}
}
?>
