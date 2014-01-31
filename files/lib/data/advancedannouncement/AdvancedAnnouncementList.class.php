<?php
namespace wcf\data\advancedannouncement; 

use wcf\data\DatabaseObjectList;

/**
 * Represents a statement list.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class AdvancedAnnouncementList extends DatabaseObjectList {

	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\advancedannouncement\AdvancedAnnouncement';

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "advancedannouncement.priority DESC";

}