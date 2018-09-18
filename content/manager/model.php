<?php
namespace content\manager;

class model extends \content_support\ticket\contact_ticket\model
{
	public static function post()
	{
		\dash\temp::set('tempTicketTitle', T_("Admin contact"));
		parent::post();
	}
}
?>