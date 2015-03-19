insert into datatech_pages (pageid, pagename, label) values (112, 'newquotesummary.php', 'Definition');
insert into datatech_pages (pageid, pagename, label) values (143, 'cancelledquote.php', 'Cancelled Quotation');
insert into datatech_pages (pageid, pagename, label) values (144, 'processedquote.php', 'Processed Quotation');
insert into datatech_pages (pageid, pagename, label) values (145, 'viewquote.php', 'View Job');
insert into datatech_pages (pageid, pagename, label) values (146, 'throwawayquoteentry.php', 'New Throw Away Quote');
insert into datatech_pages (pageid, pagename, label) values (147, 'newthrowawayquoteitem.php', 'New Throw Away Quote');
insert into datatech_pages (pageid, pagename, label) values (148, 'confirmedthrowawayquote.php', 'Throw Away Quote');
insert into datatech_pages (pageid, pagename, label) values (149, 'newthrowawayquote.php', 'New Throw Away Quote');
insert into datatech_pages (pageid, pagename, label) values (151, 'viewthrowawayquote.php', 'View Throw Away Quote');

insert into datatech_pageroles (pageid, roleid) values (112, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (143, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (144, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (145, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (146, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (147, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (148, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (149, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (151, 'PUBLIC');

insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 146, 111, 'P');

ALTER TABLE datatech_quoteheader add (	
	sungardpo varchar(20),
	ccfpath varchar(200),
	customerpo varchar(20)
);

CREATE TABLE datatech_cancelledquoteheader (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    prefix varchar(20),
    siteid int,
    status varchar(1),
    customer varchar(60),
    ccf varchar(50),
    ccfvalue varchar(50),
	sungardpo varchar(20),
	ccfpath varchar(200),
	customerpo varchar(20),
    notes text,
    cabinstalldate date,
    contactid int,
    internalapprovalcode varchar(20),
    approvalid varchar(20),
    requiredby date,
    costcode varchar(15),
    createdby int,
    createddate TIMESTAMP(14) NULL,
    scheduledby int,
    scheduleddate TIMESTAMP(14) NULL,
    ceapprovedby int,
    ceapproveddate TIMESTAMP(14) NULL,
    approvedby int,
    approveddate TIMESTAMP(14) NULL,
    archivedby int,
    archiveddate TIMESTAMP(14) NULL,
    qaby int,
    qadate TIMESTAMP(14) NULL,
    completedby int,
    completeddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE datatech_cancelledquoteitem (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    headerid int,
    linenumber int,
    description varchar(255),
    cat1 int,
    cat2 int,
    cat3 int,
    productid int,
    lengthid int,
    notes text,
    qty double,
    price double,
    total double,
    manneddays int,
    labourratehours varchar(3),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_cancelledquoteitem on datatech_quoteitem(headerid, linenumber);

CREATE TABLE datatech_cancelledquoteitemlongline (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    quoteitemid int,
    fromareaid int,
    fromcabinet varchar(255),
    toareaid int,
    tocabinet varchar(255),
    notes varchar(255),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE datatech_cancelledquoteitempanel (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    quoteitemid int,
    fromareaid int,
    fromcabinet varchar(255),
    fromposition varchar(1),
    fromlocation varchar(1),
    fromuloc varchar(10),
    toareaid int,
    tocabinet varchar(255),
    toposition varchar(1),
    tolocation varchar(1),
    touloc varchar(10),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


UPDATE datatech_pages set label = "Dashboard" where label = "Home";



insert into datatech_categories(parentcategoryid, name, createdby, createddate) VALUES (0, 'Expedite Charge', 1, NOW());
insert into datatech_categories(parentcategoryid, name, createdby, createddate) VALUES (0, 'Emergency Charge', 1, NOW());


--- LAST UPDATE MARKER
ALTER TABLE datatech_quoteheader add (	
	cancelledby int,
	cancelleddate TIMESTAMP(14) NULL
);

alter table datatech_quoteheader change ccfpath ccfpath varchar(200);
alter table datatech_cancelledquoteheader change ccfpath ccfpath varchar(200);

insert into datatech_pages (pageid, pagename, label) values (152, 'listcancelledjobs.php', 'List Cancelled Jobs');
insert into datatech_pageroles (pageid, roleid) values (152, 'ADMIN');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 152, 122, 'P');

insert into datatech_pages (pageid, pagename, label) values (153, 'listmycancelledquotes.php', 'List My Cancelled Quotes');
insert into datatech_pageroles (pageid, roleid) values (153, 'PUBLIC');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 153, 123, 'P');

insert into datatech_pages (pageid, pagename, label) values (163, 'calendar.php', 'Calendar');
insert into datatech_pageroles (pageid, roleid) values (163, 'ADMIN');
insert into datatech_pageroles (pageid, roleid) values (163, 'SCHEDULE');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 163, 133, 'P');

insert into datatech_pages (pageid, pagename, label) values (164, 'runalerts.php', 'Run Alerts');
insert into datatech_pageroles (pageid, roleid) values (164, 'ADMIN');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (3, 164, 134, 'P');

ALTER TABLE datatech_quoteheader add (	
	approvalrequesteddate TIMESTAMP(14) NULL
);

UPDATE datatech_quoteheader set approvalrequesteddate = createddate WHERE approvalrequesteddate IS NULL;

insert into datatech_pages (pageid, pagename, label) values (165, 'cancellationroute.php', 'Cancellation Routes');
insert into datatech_pageroles (pageid, roleid) values (165, 'ADMIN');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (3, 165, 135, 'P');

CREATE TABLE datatech_cancellationroute (
  id varchar(20) DEFAULT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE datatech_roleroutes (
   id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
   routeid varchar(20) DEFAULT NULL,
   roleid varchar(20) DEFAULT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_roleroutes ON datatech_roleroutes (routeid, roleid);

ALTER TABLE datatech_siteconfig  add (	
	stageapproval VARCHAR(20) NULL,
	stageceapproval VARCHAR(20) NULL,
	stagecomplete VARCHAR(20) NULL,
	stagescheduled VARCHAR(20) NULL,
	stageqa VARCHAR(20) NULL
);


insert into datatech_pages (pageid, pagename, label) values (154, 'listpendingcancelledjobs.php', 'List Pending Cancelled Jobs');
insert into datatech_pageroles (pageid, roleid) values (154, 'ADMIN');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 154, 121, 'P');

ALTER TABLE datatech_quoteheader add (	
	originalstatus VARCHAR(1) NULL
);

CREATE TABLE datatech_cancelledjobflowheader (
   id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
   quoteid int DEFAULT NULL,
   routeid varchar(20) DEFAULT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_cancelledjobflowheader ON datatech_cancelledjobflowheader (quoteid, routeid);

CREATE TABLE datatech_cancelledjobflowdetail (
   id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
   flowheaderid int DEFAULT NULL,
   roleid varchar(20) DEFAULT NULL,
   status varchar(1) DEFAULT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_cancelledjobflowdetail ON datatech_cancelledjobflowdetail (flowheaderid, roleid);

insert into datatech_pages (pageid, pagename, label) values (156, 'confirmcancellation.php', 'Confirm Cancellation');
insert into datatech_pageroles (pageid, roleid) values (156, 'PUBLIC');

ALTER TABLE datatech_cancelledjobflowdetail add (	
	processeddate TIMESTAMP(14) NULL,
	processedby int NULL
);


ALTER TABLE datatech_pagenavigation add (
	divider int NULL
);

UPDATE datatech_pagenavigation SET divider = 0;
UPDATE datatech_pagenavigation SET divider = 1 WHERE childpageid = 100;
UPDATE datatech_pagenavigation SET divider = 1 WHERE childpageid = 146;
UPDATE datatech_pagenavigation SET divider = 1 WHERE childpageid = 300;
UPDATE datatech_pagenavigation SET divider = 1 WHERE childpageid = 240;
UPDATE datatech_pagenavigation SET divider = 1 WHERE childpageid = 163;

UPDATE datatech_pages SET label = 'Complete Jobs' where pageid = 140;
UPDATE datatech_pages SET label = 'Complete Jobs (Graphs)' where pageid = 300;
UPDATE datatech_pages SET label = 'Active Jobs' where pageid = 130;
UPDATE datatech_pages SET label = 'Active Jobs (Chart)' where pageid = 230;
UPDATE datatech_pages SET label = 'Schedule Calendar' where pageid = 163;

UPDATE datatech_pagenavigation SET sequence = 121 where childpageid = 153;
UPDATE datatech_pagenavigation SET sequence = 122 where childpageid = 240;
UPDATE datatech_pagenavigation SET sequence = 123 where childpageid = 154;
UPDATE datatech_pagenavigation SET sequence = 124 where childpageid = 152;
UPDATE datatech_pagenavigation SET sequence = 142 where childpageid = 163;

UPDATE datatech_pagenavigation SET sequence = 50 where childpageid = 8;
UPDATE datatech_pagenavigation SET sequence = 51 where childpageid = 190;
UPDATE datatech_pagenavigation SET sequence = 52 where childpageid = 11;
UPDATE datatech_pagenavigation SET divider = 1 WHERE childpageid = 11;

UPDATE datatech_pagenavigation SET sequence = 900 where childpageid = 164;
UPDATE datatech_pagenavigation SET divider = 1 WHERE childpageid = 15;

UPDATE datatech_pages SET label = 'Manage Roles' where pageid = 11;

insert into datatech_pages (pageid, pagename, label) values (157, 'cancelledthrowawayquote.php', 'Confirm Cancellation');
insert into datatech_pageroles (pageid, roleid) values (157, 'PUBLIC');

UPDATE datatech_quoteitem SET cat2 = 0 where labourratehours != "";


DROP INDEX ix_documents on datatech_documents;


ALTER TABLE datatech_documents add (
	sessionid varchar(50) NULL
);


insert into datatech_pages (pageid, pagename, label) values (2000, 'system-login.php', 'Account log in');
insert into datatech_pageroles (pageid, roleid) values (2000, 'PUBLIC');



update datatech_pageroles SET 
datatech_pageroles.roleid = 'USER' 
where roleid = 'PUBLIC'
AND pageid in (
select pageid from datatech_pages 
where pagename not like 'syste%'
)


update datatech_pages SET label = 'List My Throw Away Quotes' where pageid = 153;

ALTER TABLE datatech_roles add (
	systemrole varchar(1) NULL
);

UPDATE datatech_roles SET systemrole = 'N' where systemrole is NULL;
UPDATE datatech_roles SET systemrole = 'Y' where roleid IN ('PUBLIC', 'USER');

ALTER TABLE datatech_members add (
	systemuser varchar(1) NULL
);

UPDATE datatech_members SET systemuser = 'N' where systemuser is NULL;
UPDATE datatech_members SET systemuser = 'Y' where member_id = 1;

UPDATE datatech_pages set label = 'Register New User' where label = 'Register';

update datatech_pages SET label = 'List My Cancelled Quotes' where pageid = 153;

insert into datatech_pageroles (pageid, roleid) values (163, 'PUBLIC');

insert into datatech_pages (pageid, pagename, label) values (166, 'listmythrowawayquotes.php', 'List My Throw Away Quotes');
insert into datatech_pageroles (pageid, roleid) values (166, 'PUBLIC');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 166, 112, 'P');

ALTER TABLE datatech_cancelledquoteheader add (
	throwaway varchar(1) NULL
);



UPDATE datatech_cancelledquoteheader set throwaway = 'Y' where throwaway IS NULL;

CREATE TABLE datatech_tasks (
   id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
   description varchar(60) DEFAULT NULL,
   phpfile varchar(40) DEFAULT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_tasks ON datatech_tasks (description);

CREATE TABLE datatech_taskschedule (
   id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
   taskid int NOT NULL,
   mode varchar(1) DEFAULT NULL,
   lastrun TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_taskschedule ON datatech_taskschedule (taskid);

INSERT INTO datatech_tasks (id, description, phpfile) VALUES (1, 'Run Alerts', 'backgroundalerts.php');
INSERT INTO datatech_taskschedule (taskid, mode) VALUES (1, 'M');

