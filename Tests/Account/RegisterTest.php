<?php

require_once dirname(__FILE__).'/../TestcaseAbstract.php';

/**
 * Class Acceptance_Tests_Account_Register
 *
 * @author Fabrizio Branca
 * @since 2013-05-16
 */
class Acceptance_Tests_Account_Register extends Acceptance_Tests_TestcaseAbstract {

	/**
	 * Register a new random user account
	 *
	 * @test
	 */
	public function register() {
		$account = Menta_ComponentManager::get('ProjectComponents_Page_Magento_CustomerAccount'); /* @var $account ProjectComponents_Page_Magento_CustomerAccount */
		$account->openRegistrationPage();

		$password = $account->createRandomPassword();

		$userAccount = array(
			'firstname' => 'Test_' . $this->getTestId(),
			'lastname' => 'User_' . $this->getTestId(),
			'email_address' => $account->createNewMailAddress(),
			'password' => $password,
			'confirmation' => $password
		);

		// this information will be displayed in the html report
		$this->addInfo('E-Mail: ' . $userAccount['email_address']);
		$this->addInfo('Password: ' . $userAccount['password']);

		// populate form
		$account->populateRegistrationForm($userAccount);
		$account->submitRegistrationForm();

		$this->getHelperAssert()->assertBodyClass('customer-account-index');
		$this->getHelperAssert()->assertElementEqualsToText('css=li.success-msg > ul > li', 'Thank you for registering with Main Store.');

		$this->takeScreenshot('Fresh user account after registration');

		return $userAccount;
	}

	/**
	 * Login with the user account that was created in
	 * Acceptance_Tests_Account_Register::register()
	 *
	 * @test
	 * @param $userAccount
	 * @depends register
	 */
	public function login($userAccount) {
		if (empty($userAccount)) {
			$this->markTestSkipped('No useraccout found from previous test');
		}

		$account = Menta_ComponentManager::get('ProjectComponents_Page_Magento_CustomerAccount'); /* @var $account ProjectComponents_Page_Magento_CustomerAccount */
		$account->login($userAccount['email_address'], $userAccount['password']);
	}

}