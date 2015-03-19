insert into datatech_roles (roleid, systemrole) values ('PROJECTSUPPORT', 'N');
insert into datatech_roles (roleid, systemrole) values ('PRODUCTADMIN', 'N');

insert into datatech_userroles (roleid, memberid) select 'PROJECTSUPPORT', member_id FROM datatech_members where login = 'project.support';
insert into datatech_userroles (roleid, memberid) select 'PRODUCTADMIN', member_id FROM datatech_members where login = 'as.uk.productadmin';



ALTER TABLE datatech_cancelledquoteheader add (	
	ccfschedule varchar(50)
);

ALTER TABLE datatech_quoteheader add (	
	ccfschedule varchar(50)
);
