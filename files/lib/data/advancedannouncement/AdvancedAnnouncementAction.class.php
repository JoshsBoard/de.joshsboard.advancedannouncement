<?php

namespace wcf\data\advancedannouncement;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\IToggleAction;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\data\user\UserEditor;

/**
 * Provides functions to handle premium-groups.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
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

	public function validateDismiss() {
		if (empty($this->objects)) {
			$this->readObjects();
		}

		foreach ($this->objects as $aa) {
			if (!$aa->removable)
				throw new PermissionDeniedException();
		}
	}

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
