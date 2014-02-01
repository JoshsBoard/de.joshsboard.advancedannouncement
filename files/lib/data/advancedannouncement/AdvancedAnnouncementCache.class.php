<?php

namespace wcf\data\advancedannouncement;

use wcf\system\cache\builder\AdvancedAnnouncementCacheBuilder;
use wcf\system\SingletonFactory;

/**
 * Manages the advanced-announcement cache
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.advancedannouncement
 */
class AdvancedAnnouncementCache extends SingletonFactory {

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
	 * @param        integer	$announcementID
	 * @return       wcf\data\advancedannouncement\advancedAnnouncement
	 */
	public function getAnnouncement($announcementID) {
		if (isset($this->announcements[$announcementID]))
			return $this->announcements[$announcementID];

		return null;
	}

	/**
	 * Returns all announcements
	 * 
	 * @return        array<wcf\data\advancedannouncement\advancedAnnouncement>
	 */
	public function getAnnouncements() {
		return $this->announcements;
	}

}
