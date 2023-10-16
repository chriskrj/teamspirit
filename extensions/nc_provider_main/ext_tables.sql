#
# Add SQL definition of database tables
#
CREATE TABLE pages
(
	headline varchar(255) DEFAULT '' NOT NULL,
	linklabel varchar(255) DEFAULT '' NOT NULL,
);

CREATE TABLE tt_content
(
	background_color_class varchar(255) DEFAULT 'default' NOT NULL,
	theme varchar(255) DEFAULT 'light' NOT NULL,
);
