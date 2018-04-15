<?php
namespace content_a\group\partner;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new group request"). ' | '. T_('Step 3'));
		\dash\data::page_desc(T_('fill your partner detail'). ' '. T_('partner can be family or friends'). ' '. T_('Also you can skip this step and register only for yours without partner'));

		\dash\data::childList(\lib\db\travelusers::get_travel_child(\dash\request::get('trip')));

  		$child_list =
  		[
	  		T_('Father'),
	  		T_('Mother'),
	  		T_('Sister'),
	  		T_('Brother'),
	  		T_('Grandfather'),
	  		T_('Grandmother'),
	  		T_('Aunt'),
	  		T_('Husband'),
	  		T_('Uncle'),
	  		T_('Boy'),
	  		T_('Girl'),
	  		T_('Spouse'),
	  		T_('Stepmother'),
	  		T_('Stepfather'),
	  		T_('Neighbor'),
	  		T_('Teacher'),
	  		T_('Friend'),
	  		T_('Boss'),
	  		T_('Supervisor'),
	  		T_('Child'),
	  		T_('Grandson'),
  		];

  		\dash\data::nesbatList(implode(',', $child_list));

		\dash\data::editMode(true);

		$id = \dash\request::get('edit');

		\dash\data::childDetail(null);

		if(is_numeric($id))
		{
			\dash\data::childDetail(\dash\db\users::get(['id' => $id, 'parent' => \dash\user::id(), 'limit' => 1]));
		}

		if(!\dash\data::childDetail())
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}
}
?>
