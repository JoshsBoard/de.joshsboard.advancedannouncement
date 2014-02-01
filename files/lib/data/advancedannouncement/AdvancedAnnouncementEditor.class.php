<?php
namespace wcf\data\advancedannouncement; 

use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject; 
use wcf\system\cache\builder\AdvancedAnnouncementCacheBuilder; 

/**
 * Provides functions to edit advanced-announcements.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.advancedannouncement
 */
class AdvancedAnnouncementEditor extends DatabaseObjectEditor implements IEditableCachedObject {

	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\advancedannouncement\AdvancedAnnouncement';

	/**
	 * clears the advanced announcement cache
	 */
	public static function resetCache() {
		AdvancedAnnouncementCacheBuilder::getInstance()->reset(); 
	}
}
