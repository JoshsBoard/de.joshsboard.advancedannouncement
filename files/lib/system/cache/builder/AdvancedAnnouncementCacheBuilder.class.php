<?php
namespace wcf\system\cache\builder;

use wcf\data\advancedannouncement\AdvancedAnnouncementList;

/**
 * Caches the announcements
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.advancedannouncement
 * @subpackage     system.cache.builder
 */
class AdvancedAnnouncementCacheBuilder extends \wcf\system\cache\builder\AbstractCacheBuilder {
        /**
         * @see wcf\system\cache\AbstractCacheBuilder::rebuild()
         */
        public function rebuild(array $parameters) {
			$list = new AdvancedAnnouncementList(); 
		
			if (isset($parameters['onlyActive']) && $parameters['onlyActive']) {
				$list->getConditionBuilder()->add("advancedannouncement.isDisabled = ?", array(0));
			}
		
			$list->readObjects();
		
            return $list->getObjects();
        }
}