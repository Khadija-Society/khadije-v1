UPDATE comments set comments.type = 'ticket' where comments.type = 'contact';
UPDATE comments set comments.type = 'ticket', comments.title = 'ارتباط با مدیریت' where comments.type = 'admincontact';