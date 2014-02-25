<?php

namespace wcf\data\advancedannouncement;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\user\UserEditor;
use wcf\data\user\group\UserGroup; 
use wcf\data\IToggleAction;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;

/**
 * Provides functions to handle advanced-announcements.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.advancedannouncement
 */
class AdvancedAnnouncementAction extends AbstractDatabaseObjectAction implements IToggleAction {

	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\advancedannouncement\AdvancedAnnouncementEditor';

	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.advancedannouncement.canManage');

	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.advancedannouncement.canManage');

	/**
	 * @see \wcf\data\AbstractDatabaseObjectAction::validateCreate()
	 */
	public function validateCreate() {
		parent::validateCreate();
		
		if (isset($this->parameters['usergroups'])) {
			if (!is_array($this->parameters['usergroups'])) {
				throw new UserInputException('usergroups should be an array');
			}
			
			foreach ($this->parameters['usergroups'] as $groupID => $type) {
				switch ($type) {
					case AdvancedAnnouncement::GROUP_TYPE_EXCLUDE: 
					case AdvancedAnnouncement::GROUP_TYPE_INCLUDE:
						break; 
					
					default: 
						throw new UserInputException('usergroup type are invalid');
				}
				
				$group = new UserGroup($groupID); 
				
				if ($group->getObjectID() == 0) {
					throw new UserInputException('usergroup group are invalid');
				}
			}
		}
	}
	
	/**
	 * @see \wcf\data\AbstractDatabaseObjectAction::create()
	 */
	public function create() {
		$create = parent::create();
		
		if (isset($this->parameters['usergroups'])) {
			$stmt = WCF::getDB()->prepareStatement("INSERT INTO wcf1_advancedannouncement_groups (advancedannouncementID, groupID, type) VALUES (?, ?, ?)");
			
			foreach ($this->parameters['usergroups'] as $groupID => $type) {
				$stmt->execute(array(
				    $create->getObjectID(), 
				    $groupID, 
				    $type
				));
			}
		}
		
		return $create; 
	}
	
	public function validateUpdate() {
		parent::validateUpdate();
		
		if (isset($this->parameters['usergroups'])) {
			if (!is_array($this->parameters['usergroups'])) {
				throw new UserInputException('usergroups should be an array');
			}
			
			foreach ($this->parameters['usergroups'] as $groupID => $type) {
				switch ($type) {
					case AdvancedAnnouncement::GROUP_TYPE_EXCLUDE: 
					case AdvancedAnnouncement::GROUP_TYPE_INCLUDE:
						break; 
					
					default: 
						throw new UserInputException('usergroup type are invalid');
				}
				
				$group = new UserGroup($groupID); 
				
				if ($group->getObjectID() == 0) {
					throw new UserInputException('usergroup group are invalid');
				}
			}
		}
	}
	
	public function update() {
		parent::update();
		
		if (isset($this->parameters['usergroups'])) {
			foreach ($this->objects as $object) {
				$aa = $object->getDecoratedObject(); 
				
				$groups = $aa->getUserGroups(); 
				
				$stmtC = WCF::getDB()->prepareStatement("INSERT INTO wcf1_advancedannouncement_groups (advancedannouncementID, groupID, type) VALUES (?, ?, ?)");
				$stmtU = WCF::getDB()->prepareStatement("UPDATE wcf1_advancedannouncement_groups SET type = ? WHERE advancedannouncementID = ? AND groupID = ?");
				
				foreach ($this->parameters['usergroups'] as $groupID => $type) {
					if (!isset($groups[$object->getObjectID()])) {
						$stmtC->execute(array(
						    $object->getObjectID(), 
						    $groupID, 
						    $type
						));
					} else if ($groups[$object->getObjectID()] != $type) {
						$stmtU->execute(array(
						    $type, 
						    $object->getObjectID(), 
						    $groupID
						));
					}
				}
			}
		}
	}


	/**
	 * @see	\wcf\data\IToggleAction::validateToggle()
	 */
	public function validateToggle() {
		$this->validateUpdate();
	}

	/**
	 * @see	\wcf\data\IToggleAction::toggle()
	 */
	public function toggle() {
		foreach ($this->objects as $aa) {
			$aa->update(array(
				'isDisabled' => ($aa->isDisabled ? 0 : 1)
			));
		}
	}

	/**
	 * validate the dismiss-action
	 */
	public function validateDismiss() {
		if (empty($this->objects)) {
			$this->readObjects();
		}

		foreach ($this->objects as $aa) {
			if (!$aa->removable) {
				throw new PermissionDeniedException();
			}
		}
	}

	/**
	 * dismiss an announcement to hide it from the user
	 */
	public function dismiss() {
		$ids = unserialize(WCF::getUser()->advancedannouncement);

		if (!is_array($ids)) {
			$ids = array();
		}

		foreach ($this->objects as $aa) {
			$ids[] = $aa->getObjectID();
		}

		$ids = array_unique($ids);

		$userEditor = new UserEditor(WCF::getUser());
		$userEditor->update(array(
			'advancedannouncement' => serialize($ids)
		));
	}

}
