<?php

namespace wcf\acp\form;

use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;
use wcf\data\advancedannouncement\AdvancedAnnouncement;
use wcf\data\advancedannouncement\AdvancedAnnouncementAction; 
use wcf\system\language\I18nHandler; 

/**
 * Shows the premium-group edit-form.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class AdvancedAnnouncementEditForm extends AdvancedAnnouncementAddForm {

	/**
	 * @see	\wcf\page\AbstractPage::$action
	 */
	public $action = 'edit';

	/**
	 * @see \wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.advancedannouncement.canManage');
	
	/**
	 * AdvancedAnnouncement
	 * @var	wcf\data\advancedannouncement\AdvancedAnnouncement
	 */
	public $advancedAnnouncement = null;

	/**
	 * advancedannouncementID
	 * @var	integer
	 */
	public $advancedannouncementID = 0;

	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['id']))
			$this->advancedannouncementID = intval($_REQUEST['id']);
		$this->advancedAnnouncement = new AdvancedAnnouncement($this->advancedannouncementID);

		if (!$this->advancedAnnouncement->advancedannouncementID)
			throw new IllegalLinkException();
	}

	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();

		if (empty($_POST)) {
			I18nHandler::getInstance()->setOptions('aa_content', PACKAGE_ID, $this->advancedAnnouncement->content, 'wcf.advancedannouncements.content\d+');
			
			$this->name = $this->advancedAnnouncement->name; 
			$this->removable = (bool) $this->advancedAnnouncement->removable;
			$this->inUserGroup = (is_array(unserialize($this->advancedAnnouncement->inUserGroup))) ? unserialize($this->advancedAnnouncement->inUserGroup) : array();
			$this->notInUserGroup = (is_array(unserialize($this->advancedAnnouncement->notInUserGroup))) ? unserialize($this->advancedAnnouncement->notInUserGroup) : array();
			$this->hasBirthday = $this->advancedAnnouncement->hasBirthday;
			$this->minActivityPoints = $this->advancedAnnouncement->minActivityPoints;
			$this->maxActivityPoints = $this->advancedAnnouncement->maxActivityPoints;
			$this->noAvatar = $this->advancedAnnouncement->noAvatar;
			$this->onSite = $this->advancedAnnouncement->onSite;
			$this->onSiteSites = (is_array(unserialize($this->advancedAnnouncement->onSiteSites))) ? unserialize($this->advancedAnnouncement->onSiteSites) : array();
			$this->timeIsOlderThan = (int) $this->advancedAnnouncement->timeIsOlderThan;
			$this->timeIsYoungerThan = (int) $this->advancedAnnouncement->timeIsYoungerThan;
			$this->priority = (int) $this->advancedAnnouncement->priority;
			$this->objectID = (is_array(unserialize($this->advancedAnnouncement->objectID))) ? unserialize($this->advancedAnnouncement->objectID) : array();
			$this->parentObjectID = (is_array(unserialize($this->advancedAnnouncement->parentObjectID))) ? unserialize($this->advancedAnnouncement->parentObjectID) : array();
			$this->objectType = (is_array(unserialize($this->advancedAnnouncement->objectType))) ? unserialize($this->advancedAnnouncement->objectType) : array();
			$this->parentObjectType = (is_array(unserialize($this->advancedAnnouncement->parentObjectType))) ? unserialize($this->advancedAnnouncement->parentObjectType) : array();
			$this->content = $this->advancedAnnouncement->content;
			$this->parseBBCodes = (bool) $this->advancedAnnouncement->parseBBCodes;
			$this->allowHTML = (bool) $this->advancedAnnouncement->allowHTML;
			$this->allowSmileys = (bool) $this->advancedAnnouncement->allowSmileys;
			$this->additionalStyleClasses = $this->advancedAnnouncement->additionalStyleClasses;
		}
	}

	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		
		$content = 'wcf.advancedannouncements.content' . $this->advancedAnnouncement->getObjectID();
		if (I18nHandler::getInstance()->isPlainValue('aa_content')) {
			I18nHandler::getInstance()->remove($content);
			$content = I18nHandler::getInstance()->getValue('aa_content');
		} else {
			I18nHandler::getInstance()->save('aa_content', $content, 'wcf.advancedannouncements');
		}
		
		$this->objectAction = new AdvancedAnnouncementAction(array($this->advancedAnnouncement), 'update', array(
		    'data' => array(
			'name' => $this->name,
			'removable' => ($this->removable) ? 1 : 0,
			'inUserGroup' => serialize($this->inUserGroup),
			'notInUserGroup' => serialize($this->notInUserGroup),
			'hasBirthday' => $this->hasBirthday,
			'minActivityPoints' => $this->minActivityPoints,
			'maxActivityPoints' => $this->maxActivityPoints,
			'noAvatar' => $this->noAvatar,
			'onSite' => $this->onSite,
			'onSiteSites' => serialize($this->onSiteSites),
			'timeIsOlderThan' => $this->timeIsOlderThan,
			'timeIsYoungerThan' => $this->timeIsYoungerThan,
			'priority' => $this->priority,
			'objectID' => serialize($this->objectID),
			'parentObjectID' => serialize($this->parentObjectID),
			'objectType' => serialize($this->objectType),
			'parentObjectType' => serialize($this->parentObjectType),
			'content' => $content,
			'parseBBCodes' => ($this->parseBBCodes) ? 1 : 0,
			'allowHTML' => ($this->allowHTML) ? 1 : 0,
			'allowSmileys' => ($this->allowSmileys) ? 1 : 0,
			'additionalStyleClasses' => $this->additionalStyleClasses
		    )
		));
		$this->objectAction->validateAction(); 
		$this->objectAction->executeAction();

		// show success
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		I18nHandler::getInstance()->assignVariables(!empty($_POST));
		
		WCF::getTPL()->assign('advancedAnnouncement', $this->advancedAnnouncement);
	}

}
