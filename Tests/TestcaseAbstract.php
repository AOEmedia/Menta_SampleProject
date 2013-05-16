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
	protected $captureScreenshotOnFailure = true;


	/**
	 * Setup
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->updateSauceLabsTestName();
	}

	/**
	 * Will send the test result to sauce labs in case we're running tests there
	 *
	 * @return void
	 */
	protected function tearDown() {
		$status = $this->getStatus();
		$this->updateSauceLabsTestStatus(!($status == PHPUnit_Runner_BaseTestRunner::STATUS_ERROR || $status == PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE));
		parent::tearDown();
	}

	/**
	 * Connect to the Sauce Labs REST api to update the test name
	 */
	public function updateSauceLabsTestName() {
		$sauceUserId = $this->getConfiguration()->getValue('testing.sauce.userId');
		$sauceAccessKey = $this->getConfiguration()->getValue('testing.sauce.accessKey');
		if (!empty($sauceUserId) && !empty($sauceAccessKey)) {
			Menta_SessionManager::getSession(); // trigger new session creation if it doesn't exist yet

			$name = get_class($this);
			$name = str_replace('Acceptance_Tests_', '', $name);
			$name = str_replace('_', '\\', $name);
			$name .=  ': ' . $this->getName(true);

			$rest = new WebDriver\SauceLabs\SauceRest($sauceUserId, $sauceAccessKey);
			$rest->updateJob(Menta_SessionManager::getSessionId(), array(WebDriver\SauceLabs\Capability::NAME => $name));
		}
	}

	/**
	 * Update Sauce Labs test status
	 *
	 * @param bool $passed
	 */
	public function updateSauceLabsTestStatus($passed) {
		$sauceUserId = $this->getConfiguration()->getValue('testing.sauce.userId');
		$sauceAccessKey = $this->getConfiguration()->getValue('testing.sauce.accessKey');
		if (!empty($sauceUserId) && !empty($sauceAccessKey)) {
			$rest = new WebDriver\SauceLabs\SauceRest($sauceUserId, $sauceAccessKey);
			$rest->updateJob(Menta_SessionManager::getSessionId(), array(WebDriver\SauceLabs\Capability::PASSED => $passed));
		}
	}

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