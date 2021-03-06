<?php
namespace wcf\data\advancedannouncement;

use wcf\data\user\avatar\DefaultAvatar;
use wcf\data\DatabaseObject;
use wcf\data\user\User; 
use wcf\data\user\UserEditor;
use wcf\data\user\UserProfile; 
use wcf\page\AbstractPage; 
use wcf\system\bbcode\MessageParser; 
use wcf\system\WCF; 
use wcf\util\DateUtil; 

/**
 * Represents a advanced Announcement in the database.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.advancedannouncement
 */
class AdvancedAnnouncement extends DatabaseObject {

	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'advancedannouncement';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'advancedannouncementID';

	/**
	 * the groups which are required
	 * @var array<String> 
	 */
	protected $groups = null; 
	
	/**
	 * the group type for require including 
	 */
	const GROUP_TYPE_INCLUDE = 'in'; 
	
	/**
	 * the group type for require excluding 
	 */
	const GROUP_TYPE_EXCLUDE = 'ex'; 
	
	/**
	 * @see wcf\data\DatabaseObject::handleData()
	 */
	public function handleData($data) {
		parent::handleData($data);
		
		$sql = "SELECT groupID, type FROM wcf1_advancedannouncement_groups WHERE advancedannouncementID = ?"; 
		$stmt = WCF::getDB()->prepareStatement($sql); 
		$stmt->execute(array($this->getObjectID()));

		$this->groups = array(); 
		
		while ($row = $stmt->fetchArray()) {
			$this->groups[$row['groupID']] = $row['type'];
		}
	}
	
	/**
	 * check, whether the announcement is displayed to the current user
	 * 
	 * @param \wcf\data\user\User		$user
	 * @param boolean			$site
	 * @param \wcf\page\AbstractPage	$siteObject
	 * @param boolean			$ignoreSite
	 * @return boolean
	 */
	public function display(User $user = null, $site = null, AbstractPage $siteObject = null, $ignoreSite = true) {
		if ($user === null) $user = WCF::getUser(); 
		
		// check wheather the announcement is disabled
		if ($this->isDisabled) return false; 
		
		// check wheather the announcement is removed
		if ($this->removable) {
			$removedAnnouncement = unserialize($user->advancedannouncement); 

			if (is_array($removedAnnouncement)) {
				if (in_array($this->advancedannouncementID, $removedAnnouncement)) {
					return false; 
				}
			} else {
				// field is invalid ; reset field
				$userEditor = new UserEditor($user);
				$userEditor->update(array(
					'advancedannouncement' => serialize(array())
				));
			}
		}
		
		// check wheather an avatar is required
		if ($this->noAvatar != -1) {
			$userProfile = new UserProfile($user); 
			// @TODO
			if ($this->noAvatar) {
				if (!($userProfile->getAvatar() instanceof DefaultAvatar)) {
					return false; 
				}
			} else {
				if ($userProfile->getAvatar() instanceof DefaultAvatar) {
					return false; 
				}
			}
		}
		
		// check time older than
		if ($this->timeIsOlderThan != -1) {
			if (TIME_NOW < $this->timeIsOlderThan) {
				return false;
			}
		}
		
		// check time younger than
		if ($this->timeIsYoungerThan != -1) {
			if (TIME_NOW > $this->timeIsYoungerThan) {
				return false;
			}
		}
		
		// check min activity points
		if ($this->minActivityPoints != -1) {
			if ($user->activityPoints < $this->minActivityPoints) {
				return false; 
			}
		}
		
		// check max activity points
		if ($this->maxActivityPoints != -1) {
			if ($user->activityPoints > $this->maxActivityPoints) {
				return false; 
			}
		}
		
		// check usergroups
		foreach ($this->getUserGroups() as $groupID => $type) {
			if ((!in_array($groupID, $user->getGroupIDs()) && $type == self::GROUP_TYPE_INCLUDE) || (in_array($groupID, $user->getGroupIDs()) && $type == self::GROUP_TYPE_EXCLUDE)) {
				return false; 
			}
		}
		
		// has birthday? 
		if ($this->hasBirthday != -1) {
			if (!isset($userProfile)) {
				$userProfile = new UserProfile($user);
				
				$year = $month = $day = 0;
				
				// @TODO use list(); 
				$value = explode('-', $userProfile->birthday);
				if (isset($value[0])) $year = intval($value[0]);
				if (isset($value[1])) $month = intval($value[1]);
				if (isset($value[2])) $day = intval($value[2]);
			
				if ($month == DateUtil::format(null, 'n') && DateUtil::format(null, 'j') == $day) {
					if ($this->hasBirthday == false) {
						return false; 
					}
				} else {
					if ($this->hasBirthday == true) {
						return false; 
					}
				}
			}
		}
		
		if ($this->onSite != -1) {
			if ($site == null && $ignoreSite !== false) {
				return false; 
			} else if (!$ignoreSite) {
				$sites = unserialize($this->onSiteSites); 
				
				if (is_array($sites)) {
					if (($this->onSite == 1 && !in_array($site, $sites)) || ($this->onSite == 0 && in_array($site, $sites))) {
						return false; 
					}
				}
			}
		}
		
		$oID = unserialize($this->objectID);
		
		if (is_array($oID) && !empty($oID)) {
			if ($siteObject instanceof AbstractPage) {
				if (!in_array($siteObject->getObjectID(), $oID)) {
					return false; 
				}
			} else if (!$ignoreSite) {
				return false; 
			}
		}
		
		$pOID = unserialize($this->parentObjectID); 
		
		if (is_array($pOID) && !empty($pOID)) {
			if ($siteObject instanceof AbstractPage) {
				if (!in_array($siteObject->getParentObjectID(), $pOID)) {
					return false; 
				}
			} else if (!$ignoreSite) {
				return false; 
			}
		}
		
		$oT = unserialize($this->objectType); 
		
		if (is_array($oT) && !empty($oT)) {
			if ($siteObject instanceof AbstractPage) {
				if (!in_array($siteObject->getObjectType(), $oT)) {
					return false; 
				}
			} else if (!$ignoreSite) {
				return false; 
			}
		}

		$pOT = unserialize($this->parentObjectType); 
		
		if (is_array($pOT) && !empty($pOT)) {
			if ($siteObject instanceof AbstractPage) {
				if (!in_array($siteObject->getParentObjectType(), $pOT)) {
					return false; 
				}
			} else if (!$ignoreSite) {
				return false; 
			}
		}
		
		return true; 
	}
	
	public function getUserGroups() {
		return $this->groups; 
	}
	
	/**
	 * parse an announcement-box
	 * 
	 * @return string
	 */
	public function parse() {
		WCF::getTPL()->assign('announcement', $this);
		
		return WCF::getTPL()->fetch('advancedAnnouncement');
	}
	
	/**
	 * parse the content
	 * 
	 * @return string
	 */
	public function getContent() {
		MessageParser::getInstance()->setOutputType('text/html');
		return MessageParser::getInstance()->parse(WCF::getLanguage()->get($this->content), $this->allowSmileys, $this->allowHTML, $this->parseBBCodes, false);
	}
}
