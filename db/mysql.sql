DROP DATABASE datatechnique;

CREATE DATABASE datatechnique;

USE datatechnique;


#
# table 'MEMBERS'
#
DROP TABLE datatech_members;

CREATE TABLE datatech_members (
  member_id int(11) unsigned NOT NULL auto_increment,
  firstname varchar(100) default NULL,
  lastname varchar(100) default NULL,
  login varchar(100) NOT NULL default '',
  passwd varchar(32) NOT NULL default '',
  email varchar(60),
  imageid int NULL,
  PRIMARY KEY  (member_id)
) TYPE=MyISAM;

insert into datatech_members (member_id, firstname, lastname, login, passwd, email) VALUES(1, "System", "Manager", "admin", "21232f297a57a5a743894a0e4a801fc3", "kevin.hilton@prodigyworks.co.uk");
insert into datatech_members (member_id, firstname, lastname, login, passwd, email) VALUES(2, "Buying", "Manager", "buying.manager", "21232f297a57a5a743894a0e4a801fc3", "kevin.hilton@prodigyworks.co.uk");

# 
# table: 'PAGES'
#
DROP TABLE datatech_pages;

CREATE TABLE datatech_pages (
  pageid  int(11) unsigned NOT NULL auto_increment,
  pagename varchar(30),
  label varchar(30) DEFAULT NULL,
  PRIMARY KEY  (pageid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_page ON datatech_pages(pagename);

insert into datatech_pages (pageid, pagename, label) values (1, 'index.php', 'Home');
insert into datatech_pages (pageid, pagename, label) values (2, 'system-access-denied.php', 'Access Denied');
insert into datatech_pages (pageid, pagename, label) values (3, 'system-admin.php', 'Admin');
insert into datatech_pages (pageid, pagename, label) values (5, 'system-login-timeout.php', 'Session Timeout');
insert into datatech_pages (pageid, pagename, label) values (6, 'system-login-failed.php', 'Login Failed');
insert into datatech_pages (pageid, pagename, label) values (8, 'system-register.php', 'Register');
insert into datatech_pages (pageid, pagename, label) values (10, 'system-register-success.php', 'Register Success');
insert into datatech_pages (pageid, pagename, label) values (11, 'system-admin-roles.php', 'Roles');
insert into datatech_pages (pageid, pagename, label) values (13, 'system-register-exec.php', 'Register Save');
insert into datatech_pages (pageid, pagename, label) values (14, 'system-imageviewer.php', 'Image Viewer');
insert into datatech_pages (pageid, pagename, label) values (15, 'dataupload.php', 'Data Upload');
insert into datatech_pages (pageid, pagename, label) values (16, 'confirmedquote.php', 'Quotation Confirmation');

# 
# table: 'PAGESROLES'
#
DROP TABLE datatech_pageroles;

CREATE TABLE datatech_pageroles (
  pageroleid int(11) unsigned NOT NULL auto_increment,
  pageid int not null,
  roleid VARCHAR(20) not null,
  PRIMARY KEY  (pageroleid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_pageroles ON datatech_pageroles(pageid, roleid);

insert into datatech_pageroles (pageid, roleid) values (1, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (2, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (3, 'ADMIN');
insert into datatech_pageroles (pageid, roleid) values (5, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (6, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (8, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (10, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (11, 'ADMIN');
insert into datatech_pageroles (pageid, roleid) values (13, 'ADMIN');
insert into datatech_pageroles (pageid, roleid) values (14, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (15, 'ADMIN');
insert into datatech_pageroles (pageid, roleid) values (16, 'PUBLIC');

# 
# table: 'PAGENAVIGATION'
#
DROP TABLE datatech_pagenavigation;

CREATE TABLE datatech_pagenavigation (
  pagenavigationid int(11) unsigned NOT NULL auto_increment,
  pageid int not null,
  childpageid int not null,
  sequence int not null,
  pagetype varchar(1),
  PRIMARY KEY  (pagenavigationid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_pagenav ON datatech_pagenavigation(pageid, childpageid, sequence);

insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 1, 1, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 3, 200, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (3, 8, 300, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (3, 15, 400, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (3, 11, 500, 'P');

# 
# table: 'ROLES'
#
DROP TABLE datatech_roles;

CREATE TABLE datatech_roles (
  roleid varchar(20) DEFAULT NULL,
  PRIMARY KEY  (roleid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into datatech_roles (roleid) values ('PUBLIC');
insert into datatech_roles (roleid) values ('ADMIN');
insert into datatech_roles (roleid) values ('PUBLISHER');
insert into datatech_roles (roleid) values ('USER');
insert into datatech_roles (roleid) values ('CREATOR');
insert into datatech_roles (roleid) values ('APPROVAL');
insert into datatech_roles (roleid) values ('SCHEDULE');
insert into datatech_roles (roleid) values ('QA');
insert into datatech_roles (roleid) values ('CEAPPROVAL');
insert into datatech_roles (roleid) values ('COMPLETE');
insert into datatech_roles (roleid) values ('ARCHIVE');
insert into datatech_roles (roleid) values ('POMANAGER');
insert into datatech_roles (roleid) values ('APPROVALLEVEL1');
insert into datatech_roles (roleid) values ('APPROVALLEVEL2');
insert into datatech_roles (roleid) values ('APPROVALLEVEL3');

# 
# table: 'USERROLES'
#
DROP TABLE datatech_userroles;

CREATE TABLE datatech_userroles (
  userroleid int(11) unsigned NOT NULL auto_increment,
  roleid varchar(20) DEFAULT NULL,
  memberid int(11) DEFAULT NULL,
  PRIMARY KEY  (userroleid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE UNIQUE INDEX ix_userroles ON datatech_userroles(roleid, memberid);

insert into datatech_userroles (roleid, memberid) values ('PUBLIC', 1);
insert into datatech_userroles (roleid, memberid) values ('ADMIN', 1);
insert into datatech_userroles (roleid, memberid) values ('PUBLISHER', 1);
insert into datatech_userroles (roleid, memberid) values ('USER', 1);
insert into datatech_userroles (roleid, memberid) values ('APPROVAL', 1);
insert into datatech_userroles (roleid, memberid) values ('SCHEDULE', 1);
insert into datatech_userroles (roleid, memberid) values ('IMPLEMENT', 1);
insert into datatech_userroles (roleid, memberid) values ('QA', 1);
insert into datatech_userroles (roleid, memberid) values ('ARCHIVE', 1);
insert into datatech_userroles (roleid, memberid) values ('CREATOR', 1);



DROP TABLE datatech_images;

CREATE TABLE datatech_images (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    path CHAR(255) DEFAULT '',
    mimetype CHAR(50) DEFAULT '',
    name CHAR(255) DEFAULT '',
    imgwidth SMALLINT(4) DEFAULT 0,
    imgheight SMALLINT(4) DEFAULT 0,
    tag CHAR(255) DEFAULT '',
    description CHAR(255) DEFAULT '',
    image LONGBLOB NULL,
    createddate TIMESTAMP(14) NULL,
    PRIMARY KEY (id), KEY ID(id), 
   FULLTEXT KEY search_index(name, description)) 
TYPE=MyISAM; 


DROP TABLE datatech_messages;

CREATE TABLE datatech_messages (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    from_member_id int,
    to_member_id int,
    message text,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



insert into datatech_pages (pageid, pagename, label) values (100, 'profile.php', 'My Profile');
insert into datatech_pages (pageid, pagename, label) values (110, 'quoteentry.php', 'New Quote');
insert into datatech_pages (pageid, pagename, label) values (111, 'newquote.php', 'Definition');
insert into datatech_pages (pageid, pagename, label) values (120, 'listquotes.php', 'List My Quotes');
insert into datatech_pages (pageid, pagename, label) values (130, 'activeorders.php', 'Active Orders');
insert into datatech_pages (pageid, pagename, label) values (140, 'completedorders.php', 'Completed Orders');
insert into datatech_pages (pageid, pagename, label) values (150, 'reports.php', 'Reports');
insert into datatech_pages (pageid, pagename, label) values (170, 'processquote.php', 'Process Quote');
insert into datatech_pages (pageid, pagename, label) values (180, 'approval.php', 'Verification');
insert into datatech_pages (pageid, pagename, label) values (190, 'users.php', 'Manage Users');
insert into datatech_pages (pageid, pagename, label) values (200, 'newquoteitem.php', 'Quotation Item');
insert into datatech_pages (pageid, pagename, label) values (210, 'siteconfig.php', 'Site Configuration');
insert into datatech_pages (pageid, pagename, label) values (220, 'editquote.php', 'Edit Quote');
insert into datatech_pages (pageid, pagename, label) values (230, 'activeorderschart.php', 'Active Orders (Chart)');
insert into datatech_pages (pageid, pagename, label) values (240, 'listallquotes.php', 'List All Quotes');
insert into datatech_pages (pageid, pagename, label) values (250, 'schedule.php', 'Implementation');
insert into datatech_pages (pageid, pagename, label) values (260, 'qa.php', 'QA');
insert into datatech_pages (pageid, pagename, label) values (270, 'handover.php', 'Handover');
insert into datatech_pages (pageid, pagename, label) values (280, 'complete.php', 'Completion');
insert into datatech_pages (pageid, pagename, label) values (290, 'implement.php', 'CE Approval');
insert into datatech_pages (pageid, pagename, label) values (300, 'completeordersgraph.php', 'Completed Orders (Graph)');
insert into datatech_pages (pageid, pagename, label) values (310, 'documents.php', 'Documents');
insert into datatech_pages (pageid, pagename, label) values (320, 'viewdocuments.php', 'Documents');

insert into datatech_pageroles (pageid, roleid) values (100, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (110, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (111, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (120, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (130, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (140, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (150, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (170, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (180, 'APPROVAL');
insert into datatech_pageroles (pageid, roleid) values (190, 'ADMIN');
insert into datatech_pageroles (pageid, roleid) values (200, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (210, 'ADMIN');
insert into datatech_pageroles (pageid, roleid) values (220, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (230, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (240, 'APPROVAL');
insert into datatech_pageroles (pageid, roleid) values (240, 'SCHEDULE');
insert into datatech_pageroles (pageid, roleid) values (240, 'IMPLEMENT');
insert into datatech_pageroles (pageid, roleid) values (240, 'QA');
insert into datatech_pageroles (pageid, roleid) values (240, 'COMPLETE');
insert into datatech_pageroles (pageid, roleid) values (250, 'SCHEDULE');
insert into datatech_pageroles (pageid, roleid) values (260, 'QA');
insert into datatech_pageroles (pageid, roleid) values (270, 'ARCHIVE');
insert into datatech_pageroles (pageid, roleid) values (280, 'COMPLETE');
insert into datatech_pageroles (pageid, roleid) values (290, 'IMPLEMENT');
insert into datatech_pageroles (pageid, roleid) values (300, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (310, 'PUBLIC');
insert into datatech_pageroles (pageid, roleid) values (320, 'PUBLIC');

insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 100, 100, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 110, 110, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 120, 120, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 130, 130, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 140, 140, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 150, 150, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (3, 190, 160, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (3, 210, 170, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 230, 131, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 240, 121, 'P');
insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 300, 141, 'P');


DROP TABLE datatech_categories;

CREATE TABLE datatech_categories (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    parentcategoryid int,
    name varchar(255),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


insert into datatech_categories(parentcategoryid, name, createdby, createddate) VALUES (0, 'Sundry Items', 1, NOW());
insert into datatech_categories(parentcategoryid, name, createdby, createddate) VALUES (0, 'Bespoke', 1, NOW());
insert into datatech_categories(parentcategoryid, name, createdby, createddate) VALUES (0, 'Labour Task', 1, NOW());

create unique index ix_categoryname on datatech_categories(name, parentcategoryid);


DROP TABLE datatech_products;

CREATE TABLE datatech_products (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    categoryid int,
    name varchar(255),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_productname on datatech_products(categoryid, name);


DROP TABLE datatech_productlengths;

CREATE TABLE datatech_productlengths (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    productid int,
    length varchar(5),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_productlength on datatech_productlengths(productid, length);

DROP TABLE datatech_pricebreaks;

CREATE TABLE datatech_pricebreaks (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    productlengthid int,
    fromunit int,
    tounit int,
    price double,
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_pricebreaks on datatech_pricebreaks(productlengthid, fromunit, tounit);

DROP TABLE datatech_technicianrates;

CREATE TABLE datatech_technicianrates (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(255),
    inhourrate double,
    outhourrate double,
    sathourrate double,
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_technical on datatech_technicianrates(name);

DROP TABLE datatech_quoteheader;

CREATE TABLE datatech_quoteheader (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    prefix varchar(20),
    siteid int,
    status varchar(1),
    customer varchar(60),
    ccf varchar(50),
    ccfvalue varchar(50),
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

DROP TABLE datatech_quoteitem;

CREATE TABLE datatech_quoteitem (
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

create unique index ix_quoteitem on datatech_quoteitem(headerid, linenumber);

DROP TABLE datatech_sites;

CREATE TABLE datatech_sites (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(255),
    address1 varchar(255),
    address2 varchar(255),
    address3 varchar(255),
    address4 varchar(255),
    address5 varchar(255),
    address6 varchar(255),
    address7 varchar(255),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_sites on datatech_sites(name);

insert into datatech_sites (name, address1, address2, address3, address4, address5, address6, address7, createdby, createddate) VALUES ('LTC', 'Unit B', 'Heathrow Corporate Park', 'Green Lane', 'Hounslow', 'Middlesex', 'UK', 'TW4 6ER', 1, NOW());
insert into datatech_sites (name, address1, address2, address3, address4, address5, address6, address7, createdby, createddate) VALUES ('TC2', 'Level 6', 'Global Switch London 2', 'Global Switch House', '3 Nutmeg Lane', 'London', 'UK', 'E14 2AX', 1, NOW());
insert into datatech_sites (name, address1, address2, address3, address4, address5, address6, address7, createdby, createddate) VALUES ('TC3', 'C/O Sentrum', 'Goldsworth Park Trading Estate', 'Kestrel Way', 'Woking', 'Surrey', 'UK', 'GU21 3BA', 1, NOW());
insert into datatech_sites (name, address1, address2, address3, address4, address5, address6, address7, createdby, createddate) VALUES ('TC4', 'Unit J1', 'Lowfields Way', 'Lowfields Business Park', 'Elland', 'West Yorkshire', 'UK', 'HX5 9DA', 1, NOW());


DROP TABLE datatech_areas;

CREATE TABLE datatech_areas (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    siteid int,
    name varchar(255),
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_areas on datatech_areas(siteid, name);

insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.1', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.2', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.2A', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.3', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.4', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.A4', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.5', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.6', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.7', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.8', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'A1.A8', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'Telco 1', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'Telco 2', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'Telco 3', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (1, 'Telco 7', 1, NOW());

insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.1', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.2', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.3', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.4', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.5', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.6', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.7', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (2, 'A2.8', 1, NOW());

insert into datatech_areas(siteid, name, createdby, createddate) values (3, 'A3.1', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (3, 'A3.2', 1, NOW());

insert into datatech_areas(siteid, name, createdby, createddate) values (4, 'A4.1', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (4, 'A4.2', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (4, 'Telco 1', 1, NOW());
insert into datatech_areas(siteid, name, createdby, createddate) values (4, 'Telco 2', 1, NOW());


DROP TABLE datatech_quoteitemlongline;

CREATE TABLE datatech_quoteitemlongline (
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

DROP TABLE datatech_quoteitempanel;

CREATE TABLE datatech_quoteitempanel (
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


DROP TABLE datatech_siteconfig;

CREATE TABLE datatech_siteconfig (
    below1kid varchar(20),
    below5kid varchar(20),
    over5kid varchar(20),
    documentfolder varchar(255),
	capexdealpovalue double,
	capexnonedealpovalue double,
	opexdealpovalue double,
	opexnonedealpovalue double,
	capexdealcloudpovalue double,
	capexdealpovaluethreshold double,
	capexnonedealpovaluethreshold double,
	capexdealcloudpovaluethreshold double,
	opexdealpovaluethreshold double,
	opexnonedealpovaluethreshold double,
	currentcapexdealpovalue double,
	currentcapexnonedealpovalue double,
	currentcapexdealcloudpovalue double,
	currentopexdealpovalue double,
	currentopexnonedealpovalue double,
    createdby int,
    createddate TIMESTAMP(14) NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



insert into datatech_siteconfig (below1kid, below5kid, over5kid, documentfolder, createdby, createddate) VALUES ("ADMIN", "ADMIN", "ADMIN", '', 1, NOW());

DROP TABLE datatech_supplieditems;

CREATE TABLE datatech_supplieditems (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	productid int, 
	supplyinstalled double, 
	supplyonly double, 
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_supplieditems on datatech_supplieditems(productid);

DROP TABLE datatech_suppliedlengthprice;

CREATE TABLE datatech_suppliedlengthprice (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	productlengthid int, 
	supplyinstalled double, 
	supplyonly double, 
	installonly double, 
    createdby int,
    createddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_longlineprice on datatech_suppliedlengthprice(productlengthid);

DROP TABLE datatech_documents;

CREATE TABLE datatech_documents (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	headerid int, 
	name varchar(255), 
	filename varchar(255), 
	mimetype varchar(255),
	size int,
    image LONGBLOB NULL,
    createdby int,
    createddate TIMESTAMP(14) NULL,
    lastmodifiedby int,
    lastmodifieddate TIMESTAMP(14) NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_documents on datatech_documents(headerid, name);



DROP TABLE datatech_jobheader;

CREATE TABLE datatech_jobheader (
    id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    prefix varchar(20),
    quoteid int,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create unique index ix_jobheader on datatech_jobheader(quoteid);

DELETE FROM datatech_jobheader;

UPDATE datatech_quoteheader SET prefix = 'SQ';


INSERT INTO datatech_jobheader (quoteid, prefix) SELECT id, 'SC-211SG' FROM datatech_quoteheader WHERE status IN ('A', 'S', 'I', 'V', 'C', 'Q') AND id not in (select quoteid from datatech_jobheader);

insert into datatech_pagenavigation (pageid, childpageid, sequence, pagetype) values (1, 310, 151, 'P');

ALTER TABLE datatech_documents ADD FULLTEXT(name, filename);


alter table datatech_siteconfig add (	
	capexdealcloudpovaluethreshold double,
	currentcapexdealcloudpovalue double,
	capexdealcloudpovalue double
	);
	
	
