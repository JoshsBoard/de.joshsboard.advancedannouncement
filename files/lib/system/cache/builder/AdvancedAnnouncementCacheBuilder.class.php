<?php
namespace wcf\system\cache\builder;

use wcf\data\advancedannouncement\AdvancedAnnouncementList;
use wcf\system\cache\builder\AbstractCacheBuilder;

/**
 * Caches the announcements
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.advancedannouncement
 * @subpackage     system.cache.builder
 */
class AdvancedAnnouncementCacheBuilder extends AbstractCacheBuilder {
	
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
