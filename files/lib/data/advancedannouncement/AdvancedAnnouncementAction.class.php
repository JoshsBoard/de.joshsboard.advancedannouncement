<?php

namespace wcf\data\advancedannouncement;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\user\UserEditor;
use wcf\data\IToggleAction;
use wcf\system\exception\PermissionDeniedException;
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
			if (!$aa->removable)
				throw new PermissionDeniedException();
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
