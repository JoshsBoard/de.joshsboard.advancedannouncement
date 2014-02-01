<?php
namespace wcf\system\event\listener;

use wcf\data\advancedannouncement\AdvancedAnnouncementCache; 
use wcf\system\event\IEventListener;
use wcf\system\WCF;

/**
 * Adds jCoins mass processsing
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.advancedannouncement
 */
class AddAnnouncementsListener implements IEventListener {

	/**
	 * @see	\wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		$announcements = AdvancedAnnouncementCache::getInstance()->getAnnouncements(); 
		
		$active_announcements = array(); 
		
		foreach ($announcements as $announcement) {
			
			// cut off namespace
			if (preg_match('@\\\\([\w]+)$@', $className, $matches)) {
				$className = $matches[1];
			}

			if ($announcement->display(null, preg_replace('~(Form|Page)$~', '', $className), $eventObj, false)) {
				$active_announcements[] = $announcement; 
			}
		}
		
		WCF::getTPL()->assign(array(
			'aa_active_announcements' => $active_announcements
		));
	}
}
