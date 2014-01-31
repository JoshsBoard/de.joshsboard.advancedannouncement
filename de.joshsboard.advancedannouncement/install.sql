DROP TABLE IF EXISTS wcf1_advancedannouncement;
CREATE TABLE wcf1_advancedannouncement (
	advancedannouncementID		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name				MEDIUMTEXT,
	isDisabled			BOOLEAN			NOT NULL DEFAULT 0,
	removable			BOOLEAN			NOT NULL DEFAULT 1,
	inUserGroup			TEXT			NOT NULL, 
	notInUserGroup			TEXT			NOT NULL,
	hasBirthday			TINYINT(1)		NOT NULL DEFAULT -1,
	minActivityPoints		INT(10)			NOT NULL DEFAULT -1, 
	maxActivityPoints		INT(10)			NOT NULL DEFAULT -1,
	noAvatar			TINYINT(1)		NOT NULL DEFAULT -1,
	onSite				TINYINT(1)		NOT NULL DEFAULT 0, 
	onSiteSites			TEXT			NOT NULL, 
	timeIsOlderThan			INT(10)			NOT NULL DEFAULT -1,
	timeIsYoungerThan		INT(10)			NOT NULL DEFAULT -1, 
	priority			INT(5)			NOT NULL DEFAULT 100, 
	objectID			MEDIUMTEXT		NOT NULL, 
	parentObjectID			MEDIUMTEXT		NOT NULL,
	objectType			MEDIUMTEXT		NOT NULL, 
	parentObjectType		MEDIUMTEXT		NOT NULL,
	content				TEXT			NOT NULL, 
	parseBBCodes			BOOLEAN			NOT NULL DEFAULT 1, 
	allowHTML			BOOLEAN			NOT NULL DEFAULT 0, 
	allowSmileys			BOOLEAN			NOT NULL DEFAULT 0, 

-- style
	additionalStyleClasses		TEXT
);

ALTER TABLE  wcf1_user ADD  advancedannouncement MEDIUMTEXT;