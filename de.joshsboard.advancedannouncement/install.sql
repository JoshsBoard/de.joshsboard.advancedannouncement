DROP TABLE IF EXISTS wcf1_advancedannouncement;
CREATE TABLE wcf1_advancedannouncement (
	advancedannouncementID		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name				MEDIUMTEXT,
	isDisabled			BOOLEAN			NOT NULL DEFAULT 0,
	removable			BOOLEAN			NOT NULL DEFAULT 1,
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

DROP TABLE IF EXISTS wcf1_advancedannouncement_groups;
CREATE TABLE wcf1_advancedannouncement_groups (
	advancedannouncementID		INT(10)			NOT NULL,
	groupID         		INT(10)			NOT NULL,
        type             		ENUM('in', 'ex')	NOT NULL    -- in = include ; ex = exclude
);

ALTER TABLE  wcf1_user ADD  advancedannouncement MEDIUMTEXT;

-- foreign keys
ALTER TABLE wcf1_advancedannouncement_groups ADD FOREIGN KEY (advancedannouncementID) REFERENCES wcf1_advancedannouncement (advancedannouncementID) ON DELETE CASCADE;
ALTER TABLE wcf1_advancedannouncement_groups ADD FOREIGN KEY (groupID) REFERENCES wcf1_user_group (groupID) ON DELETE CASCADE;