<?php
namespace content_agent\servant\home;


class controller
{
	public static function routing()
	{
		if(in_array(\dash\request::get('list'), ['member']))
		{

			$query_string = \dash\request::get('q');
			if(!$query_string)
			{
				$query_string = null;
			}

			$member_search_meta = ['order' => 'desc'];

			$memberList       = \dash\app\user::list($query_string, $member_search_meta);

			$result            = [];
			$result['success'] = true;
			$result['result']  = [];

			foreach ($memberList as $key => $value)
			{
				$myName = '<img class="ui avatar image" src="'.  $value['avatar'] .'">';
				$myName .= '   '. ($value['firstname'] && $value['lastname'] ? $value['firstname']. ' <b>'. $value['lastname']. '</b>' : $value['displayname']). ' <small class="badge light mLa5">'. $value['father'].'</small>';

				$nationalcode = $value['nationalcode'];
				if(!$value['nationalcode'] && $value['pasportcode'])
				{
					$nationalcode = $value['pasportcode'];
				}

				$myName .= '<span class="badge mLa10 info2">'. \dash\utility\human::fitNumber($nationalcode, false). '</span>';

				if($value['mobile'])
				{
					$myName .= '<span class="description ">'. \dash\utility\human::fitNumber($value['mobile'], 'mobile'). '</span>';
				}




				$result['result'][] =
				[
					'name'  => $myName,
					'value' => $value['id'],
				];
			}

			$result = json_encode($result, JSON_UNESCAPED_UNICODE);
			echo $result;
			\dash\code::boom();
		}
	}
}
?>