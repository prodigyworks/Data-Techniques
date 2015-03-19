ALTER TABLE datatech_quoteheader add (	
	requiredbymode varchar(50)
);

UPDATE datatech_quoteheader SET requiredbymode = 'T' where requiredbymode;
