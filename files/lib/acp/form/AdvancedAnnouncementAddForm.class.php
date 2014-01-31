<?php

namespace wcf\acp\form;

use wcf\data\advancedannouncement\AdvancedAnnouncementAction;
use wcf\data\advancedannouncement\AdvancedAnnouncementEditor; 
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;
use wcf\data\user\group\UserGroupList;
use wcf\system\language\I18nHandler; 

/**
 * Shows the premium-group add-form.
 *
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class AdvancedAnnouncementAddForm extends AbstractForm {

	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.advancedannouncement.add';

	/**
	 * @see \wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.advancedannouncement.canManage');
	
	/**
	 * @see	\wcf\page\AbstractPage::$action
	 */
	public $action = 'add';
	public $name = '';
	public $removable = false;
	public $inUserGroup = array();
	public $notInUserGroup = array();
	public $hasBirthday = -1;
	public $minActivityPoints = -1;
	public $maxActivityPoints = -1;
	public $noAvatar = -1;
	public $onSite = -1;
	public $onSiteSites = array();
	public $timeIsOlderThan = -1;
	public $timeIsYoungerThan = -1;
	public $priority = 100;
	public $objectID = array();
	public $parentObjectID = array();
	public $objectType = array();
	public $parentObjectType = array();
	public $aa_content = "";
	public $parseBBCodes = true;
	public $allowHTML = false;
	public $allowSmileys = false;
	public $data = array();
	public $additionalStyleClasses = 'info';
	public $groups = null;
	
	/**
	 * @see	\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		I18nHandler::getInstance()->readValues();
		
		if (isset($_POST['name']))
			$this->name = $_POST['name'];
		if (isset($_POST['removable']) && $_POST['removable'] == 1)
			$this->removable = true;
		if (isset($_POST['inUserGroup']))
			$this->inUserGroup = $_POST['inUserGroup'];
		if (isset($_POST['notInUserGroup']))
			$this->notInUserGroup = $_POST['notInUserGroup'];
		if (isset($_POST['hasBirthday']))
			$this->hasBirthday = intval($_POST['hasBirthday']);
		if (isset($_POST['minActivityPoints']))
			$this->minActivityPoints = intval($_POST['minActivityPoints']);
		if (isset($_POST['maxActivityPoints']))
			$this->maxActivityPoints = intval($_POST['maxActivityPoints']);
		if (isset($_POST['noAvatar']))
			$this->noAvatar = $_POST['noAvatar'];
		if (isset($_POST['onSite']))
			$this->onSite = intval($_POST['onSite']);
		if (isset($_POST['onSiteSites']))
			$this->onSiteSites = $_POST['onSiteSites'];
		if (isset($_POST['timeIsOlderThan']))
			$this->timeIsOlderThan = intval($_POST['timeIsOlderThan']);
		if (isset($_POST['timeIsYoungerThan']))
			$this->timeIsYoungerThan = intval($_POST['timeIsYoungerThan']);
		if (isset($_POST['priority']))
			$this->priority = intval($_POST['priority']);
		if (isset($_POST['objectID']))
			$this->objectID = $_POST['objectID'];
		if (isset($_POST['parentObjectID']))
			$this->parentObjectID = $_POST['parentObjectID'];
		if (isset($_POST['objectType']))
			$this->objectType = $_POST['objectType'];
		if (isset($_POST['parentObjectType']))
			$this->parentObjectType = $_POST['parentObjectType'];
		if (isset($_POST['aa_content']))
			$this->aa_content = $_POST['aa_content'];
		if (isset($_POST['parseBBCodes']) & $_POST['parseBBCodes'] == 1)
			$this->parseBBCodes = true;
		if (isset($_POST['allowHTML']) && $_POST['allowHTML'] == 1)
			$this->allowHTML = true;
		if (isset($_POST['allowSmileys']) && $_POST['allowSmileys'] == 1)
			$this->allowSmileys = true;
		if (isset($_POST['additionalStyleClasses']))
			$this->additionalStyleClasses = $_POST['additionalStyleClasses'];

		if (!is_array($this->notInUserGroup))
			$this->parseTextToArray($this->notInUserGroup);
		if (!is_array($this->inUserGroup))
			$this->parseTextToArray($this->inUserGroup);
		if (!is_array($this->onSiteSites))
			$this->parseTextToArray($this->onSiteSites);

		if (!is_array($this->objectID))
			$this->parseTextToIntArray($this->objectID);
		if (!is_array($this->parentObjectID))
			$this->parseTextToIntArray($this->parentObjectID);

		if (!is_array($this->objectType))
			$this->parseTextToArray($this->objectType, false);
		if (!is_array($this->parentObjectType))
			$this->parseTextToArray($this->parentObjectType, false);

		if (!is_array($this->inUserGroup))
			$this->inUserGroup = array();
		if (!is_array($this->notInUserGroup))
			$this->notInUserGroup = array();
	}

	public function parseTextToIntArray(&$array) {
		$array = explode(',', $array);

		$array = array_map(function ($value) {
			$value = StringUtil::trim($value);
			
			if (empty($value)) return false;
			
			return intval($value);
		}, $array);

		$array = array_filter($array);
		$array = array_unique($array);
	}

	public function parseTextToArray(&$array, $newlines = true) {
		if ($newlines)
			$array = explode('\n', StringUtil::unifyNewlines($array));
		else
			$array = explode(',', $array);

		$array = array_map(function ($value) {
			return StringUtil::trim($value);
		}, $array);

		$array = array_filter($array);
	}

	/**
	 * @see	\wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();

		if (empty($this->name)) {
			throw new UserInputException('name', 'empty');
		}
		
		if ($this->timeIsYoungerThan !== -1) {
			$this->timeIsYoungerThan = @strtotime($this->timeIsYoungerThan);
			
			if ($this->timeIsYoungerThan == false) {
				throw new UserInputException('timeIsYoungerThan', 'notValid');
			}
		}
		
		if ($this->timeIsOlderThan !== -1) {
			$this->timeIsOlderThan = @strtotime($this->timeIsOlderThan);
			
			if ($this->timeIsOlderThan == false) {
				throw new UserInputException('timeIsOlderThan', 'notValid');
			}
		}
	}

	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();

		$this->objectAction = new AdvancedAnnouncementAction(array(), 'create', array(
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
			'content' => I18nHandler::getInstance()->isPlainValue('aa_content') ? I18nHandler::getInstance()->getValue('aa_content') : '',
			'parseBBCodes' => ($this->parseBBCodes) ? 1 : 0,
			'allowHTML' => ($this->allowHTML) ? 1 : 0,
			'allowSmileys' => ($this->allowSmileys) ? 1 : 0,
			'additionalStyleClasses' => $this->additionalStyleClasses
		    )
		));
		$returnValues = $this->objectAction->executeAction();

		// save I18n description
		if (!I18nHandler::getInstance()->isPlainValue('aa_content')) {
			$id = $returnValues['returnValues']->advancedannouncementID;

			$updateData = array();
			$updateData['content'] = 'wcf.advancedannouncements.content' . $id;
			I18nHandler::getInstance()->save('aa_content', $updateData['content'], 'wcf.advancedannouncements');
			
			// update content
			$editor = new AdvancedAnnouncementEditor($returnValues['returnValues']);
			$editor->update($updateData);
		}
		
		$this->saved();
		
		I18nHandler::getInstance()->reset();
		// reset vars
		$this->name = '';
		$this->removable = false;
		$this->inUserGroup = array();
		$this->notInUserGroup = array();
		$this->hasBirthday = -1;
		$this->minActivityPoints = -1;
		$this->maxActivityPoints = -1;
		$this->noAvatar = -1;
		$this->onSite = -1;
		$this->onSiteSites = array();
		$this->timeIsOlderThan = -1;
		$this->timeIsYoungerThan = -1;
		$this->priority = 100;
		$this->objectID = array();
		$this->parentObjectID = array();
		$this->objectType = array();
		$this->parentObjectType = array();
		$this->aa_content = "";
		$this->parseBBCodes = true;
		$this->allowHTML = false;
		$this->allowSmileys = false;
		$this->additionalStyleClasses = 'info';
		
		// show success
		WCF::getTPL()->assign('success', true);
	}

	public function readData() {
		I18nHandler::getInstance()->register('aa_content');
		
		parent::readData();

		$this->groups = new UserGroupList();
		$this->groups->readObjects();
	}

	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		I18nHandler::getInstance()->assignVariables();
		
		WCF::getTPL()->assign(array(
		    'name' => $this->name,
		    'removable' => ($this->removable) ? 1 : 0,
		    'inUserGroup' => $this->inUserGroup,
		    'notInUserGroup' => $this->notInUserGroup,
		    'hasBirthday' => $this->hasBirthday,
		    'minActivityPoints' => $this->minActivityPoints,
		    'maxActivityPoints' => $this->maxActivityPoints,
		    'noAvatar' => $this->noAvatar,
		    'onSite' => $this->onSite,
		    'onSiteSites' => $this->onSiteSites,
		    'timeIsOlderThan' => $this->timeIsOlderThan,
		    'timeIsYoungerThan' => $this->timeIsYoungerThan,
		    'priority' => $this->priority,
		    'objectID' => $this->objectID,
		    'parentObjectID' => $this->parentObjectID,
		    'objectType' => $this->objectType,
		    'parentObjectType' => $this->parentObjectType,
		    'parseBBCodes' => ($this->parseBBCodes) ? 1 : 0,
		    'allowHTML' => ($this->allowHTML) ? 1 : 0,
		    'allowSmileys' => ($this->allowSmileys) ? 1 : 0,
		    'additionalStyleClasses' => $this->additionalStyleClasses,
		    'groups' => $this->groups->getObjects()
		));
	}

}
