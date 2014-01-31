<?php
namespace wcf\data\advancedannouncement;

use wcf\system\cache\builder\AdvancedAnnouncementCacheBuilder;

/**
 * Manages the premium cache
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.jcoins
 */
class AdvancedAnnouncementCache extends \wcf\system\SingletonFactory {
	/**
	 * list of cached announcements
	 * @var        array<wcf\data\advancedannouncement\AdvancedAnnouncement>
	 */
	protected $announcements = array();
	
	/**
	 * @see        wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$this->announcements = AdvancedAnnouncementCacheBuilder::getInstance()->getData();
	}
	
	/**
         * Returns a specific group
         * 
         * @param        integer                $groupID
         * @return        wcf\data\user\group\premium\UserGroupPremium
         */
	public function getAnnouncement($announcementID) {
		if (isset($this->announcements[$announcementID]))
                        return $this->announcements[$announcementID];
                
                return null;
	}
	
	/**
         * Returns all groups
         * 
         * @param        integer                $groupID
         * @return        array<wcf\data\user\group\premium\UserGroupPremium>
         */
	public function getAnnouncements() {
		return $this->announcements; 
	}
}