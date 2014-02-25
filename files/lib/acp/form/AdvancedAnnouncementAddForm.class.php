<?php
namespace wcf\acp\form;

use wcf\data\advancedannouncement\AdvancedAnnouncement; 
use wcf\data\advancedannouncement\AdvancedAnnouncementAction;
use wcf\data\advancedannouncement\AdvancedAnnouncementEditor;
use wcf\data\user\group\UserGroupList;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\data\user\group\UserGroup; 
use wcf\system\language\I18nHandler;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Shows the advanced-announcemets add-form
 *
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.advancedannouncements
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

	/**
	 * a name for the announcement
	 * @var String 
	 */
	public $name = '';

	/**
	 * is the announcement hideable?
	 * @var boolean 
	 */
	public $removable = false;

	/**
	 * An array containing all user IDs must be in which the user, so that it is displayed.
	 * @var array<int> 
	 */
	public $inUserGroup = array();

	/**
	 * An array containing all user IDs must not be in which the user, so that it is displayed.
	 * @var array<in>
	 */
	public $notInUserGroup = array();

	/**
	 * user birthday criteria
	 * @var int 
	 */
	public $hasBirthday = -1;

	/**
	 * min activity points criteria
	 * @var int 
	 */
	public $minActivityPoints = -1;

	/**
	 * max activity points criteria
	 * @var int 
	 */
	public $maxActivityPoints = -1;

	/**
	 * avatar criteria
	 * @var int 
	 */
	public $noAvatar = -1;

	/**
	 * on site criteria
	 * @var int 
	 */
	public $onSite = -1;

	/**
	 * an array with all sites for the onSite-criteria
	 * @var array<string> 
	 */
	public $onSiteSites = array();

	/**
	 * time now is older than criteria
	 * @var int 
	 */
	public $timeIsOlderThan = -1;

	/**
	 * time now is younger than criteria
	 * @var int
	 */
	public $timeIsYoungerThan = -1;

	/**
	 * priority for the announcement
	 * @var int
	 */
	public $priority = 100;

	/**
	 * objectIDs-criteria
	 * @var array<int>
	 */
	public $objectID = array();

	/**
	 * parentObjectIDs-criteria
	 * @var array<int>
	 */
	public $parentObjectID = array();

	/**
	 * objectType-criteria
	 * @var array<string>
	 */
	public $objectType = array();

	/**
	 * parentObjectType-criteria
	 * @var array<String> 
	 */
	public $parentObjectType = array();

	/**
	 * the content for the announcement
	 * @var string 
	 */
	public $aa_content = "";

	/**
	 * defines wheather allow bbcodes in the content
	 * @var boolean
	 */
	public $parseBBCodes = true;

	/**
	 * defines wheather allow html in the content
	 * @var boolean
	 */
	public $allowHTML = false;

	/**
	 * defines wheather allow smileys in the content
	 * @var boolean
	 */
	public $allowSmileys = false;

	/**
	 * all style classes for the announcement-box
	 * @var string 
	 */
	public $additionalStyleClasses = 'info';

	/**
	 * group list 
	 * @var \wcf\data\user\group\UserGroupList 
	 */
	public $groups = null;

	/**
	 * the groups
	 * @var array<string> 
	 */
	public $vgroups = array();
	
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
			$this->notInUserGroup = array();
		if (!is_array($this->inUserGroup))
			$this->inUserGroup = array();
		
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

	/**
	 * parse an string to an array by explode them with the identifer , 
	 * 
	 * @param   mixed    $array
	 */
	public function parseTextToIntArray(&$array) {
		$array = explode(',', $array);

		$array = array_map(function ($value) {
			$value = StringUtil::trim($value);

			if (empty($value))
				return false;

			return intval($value);
		}, $array);

		$array = array_filter($array);
		$array = array_unique($array);
	}

	/**
	 * parse an string to an array by explode them with the identifer \n or , 
	 * 
	 * @param   mixed    $array
	 * @paran   boolean  $newlines  
	 */
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
		
		
		// we just ignore invalid groups
		foreach ($this->inUserGroup AS $group) {
			$group = new UserGroup(intval($group)); 
			if ($group->getObjectID() != 0) {
				$this->vgroups[$group->getObjectID()] = AdvancedAnnouncement::GROUP_TYPE_INCLUDE;
			}
		}
		
		foreach ($this->notInUserGroup AS $group) {
			$group = new UserGroup(intval($group)); 
			if ($group->getObjectID() != 0) {
				$this->vgroups[$group->getObjectID()] = AdvancedAnnouncement::GROUP_TYPE_EXCLUDE; 
			}
		}
	}

	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();

		$this->objectAction = new AdvancedAnnouncementAction(array(), 'create', array(
			'usergroups' => $this->vgroups,
			'data' => array(
				'name' => $this->name,
				'removable' => ($this->removable) ? 1 : 0,
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

	/**
	 * @see	\wcf\page\IPage::readData()
	 */
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
