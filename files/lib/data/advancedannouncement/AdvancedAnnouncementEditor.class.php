<?php
namespace wcf\data\advancedannouncement; 

use wcf\data\DatabaseObjectEditor;
use wcf\system\cache\builder\AdvancedAnnouncementCacheBuilder; 

/**
 * Provides functions to edit statements.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class AdvancedAnnouncementEditor extends DatabaseObjectEditor implements \wcf\data\IEditableCachedObject {

	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\advancedannouncement\AdvancedAnnouncement';

	/**
	 * clears the premium-group cache
	 */
	public static function resetCache() {
		AdvancedAnnouncementCacheBuilder::getInstance()->reset(); 
	}
}
