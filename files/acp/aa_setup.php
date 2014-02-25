<?php
/**
 * add a default announcement
 */

$objectAction = new wcf\data\advancedannouncement\AdvancedAnnouncementAction(array(), 'create', array(
	'usergroups' => array(array(4 => wcf\data\advancedannouncement\AdvancedAnnouncement::GROUP_TYPE_INCLUDE)),
	'data' => array(
		'name' => "Example-Announcement",
		'removable' => 1,
		'hasBirthday' => -1,
		'minActivityPoints' => -1,
		'maxActivityPoints' => -1,
		'noAvatar' => -1,
		'onSite' => 0,
		'onSiteSites' => serialize(array()),
		'timeIsOlderThan' => -1,
		'timeIsYoungerThan' => -1,
		'priority' => 10,
		'objectID' => serialize(array()),
		'parentObjectID' => serialize(array()),
		'objectType' => serialize(array()),
		'parentObjectType' => serialize(array()),
		'content' => 'wcf.advancedannouncements.content1',
		'parseBBCodes' => 1,
		'allowHTML' => 0,
		'allowSmileys' => 1,
		'additionalStyleClasses' => 'info'
	)));
$returnValues = $objectAction->executeAction();
