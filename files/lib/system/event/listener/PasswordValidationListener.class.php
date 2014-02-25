<?php
namespace wcf\system\event\listener;
 
use wcf\system\exception\UserInputException;

/**
 * Adds a custom password validation
 * 
 * @author	Joshua Rüsweg
 */
class PasswordValidationListener implements IEventListener {

	/**
	 * @see	\wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if ($className != 'AccountManagementForm') {
			if (mb_strlen($eventObj->password) > 15) {
				throw new UserInputException('password'); 
			} 
		} else {
			if (mb_strlen($eventObj->newPassword) > 15) {
				throw new UserInputException('newPassword'); 
			} 
		}
	}
}
