<?php
namespace wcf\acp\page;

use wcf\page\SortablePage;

/**
 * Represents a list of all announcements
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.advancedannouncements
 */
class AdvancedAnnouncementListPage extends SortablePage {

	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.advancedannouncement.list';

	/**
	 * @see	wcf\page\MultipleLinkPage::$defaultSortField
	 */
	public $defaultSortField = 'advancedannouncementID';

	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\advancedannouncement\AdvancedAnnouncementList';

	/**
	 * @see	wcf\page\MultipleLinkPage::$validSortFields
	 */
	public $validSortFields = array('advancedannouncementID', 'name', 'priority');

}
