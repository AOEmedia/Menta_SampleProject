<?php

require_once dirname(__FILE__) . '/bootstrap.php'; // bootstrapping Menta
require_once TEST_ROOTDIR . 'ProjectComponents/bootstrap.php';

/**
 * Abstract base class for all project testcases
 *
 * @author Fabrizio Branca
 */
abstract class Acceptance_Tests_TestcaseAbstract extends Menta_PHPUnit_Testcase_Selenium2 {

	protected $cleanupPreviousSession = false; // not needed if we have a new session anyway
	protected $freshSessionForEachTestMethod = true;


	/**
	 * Convenience methods...
	 */

	/**
	 * Get common helper
	 *
	 * @return Menta_Component_Helper_Common
	 */
	protected function getHelperCommon() {
		return Menta_ComponentManager::get('Menta_Component_Helper_Common');
	}

	/**
	 * Get assert helper
	 *
	 * @return Menta_Component_Helper_Assert
	 */
	protected function getHelperAssert() {
		return Menta_ComponentManager::get('Menta_Component_Helper_Assert');
	}

	/**
	 * Get assert helper
	 *
	 * @return Menta_Component_Helper_Wait
	 */
	protected function getHelperWait() {
		return Menta_ComponentManager::get('Menta_Component_Helper_Wait');
	}

}