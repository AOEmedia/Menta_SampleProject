<?php

/**
 * Class ProjectComponents_Page_Magento_CustomerAccount
 */
class ProjectComponents_Page_Magento_CustomerAccount extends Menta_Component_AbstractTest {

	/**
	 * Path for element which is present only on dashboard page
	 *
	 * @return string
	 */
	public function getDashboardIndicatorPath() {
		return 'id=dash';
	}

	/**
	 * @return string
	 */
	public function getSplitPageRegistrationButtonPath() {
		return "//div[contains(@class,'account-login')]//button//*[contains(text(),'Register')]";
	}

	/**
	 * Open login/register page
	 *
	 * @return void
	 */
	public function openSplitLoginOrRegister() {
		$this->getHelperCommon()->open('/customer/account/login/');
		$this->getHelperAssert()->assertBodyClass('customer-account-login');
		$this->getHelperAssert()->assertTextPresent($this->__('Login or Create an Account'));
		$this->getHelperAssert()->assertTextPresent($this->__('New Customers'));
		$this->getHelperAssert()->assertTextPresent($this->__('Registered Customers'));
	}

	/**
	 * Got to dashboard
	 *
	 * @return void
	 */
	public function openDashboard() {
		$this->getHelperCommon()->open('/customer/account/');
		$this->assertIsOnDashboard();
	}

	public function assertIsOnDashboard() {
		$this->getHelperAssert()->assertTitle($this->__('My Account'));
		$this->getHelperAssert()->assertTextPresent($this->__('My Dashboard'));
		$this->getHelperAssert()->assertElementPresent($this->getDashboardIndicatorPath());
	}

	/**
	 * Got to history
	 *
	 * @return void
	 */
	public function openOrderHistory() {
		$this->getHelperCommon()->open('/sales/order/history/');
		$this->getHelperAssert()->assertTitle('My Orders');
	}

	/**
	 * Open an order from the order history
	 *
	 * @param string $orderId
	 * @return void
	 */
	public function openOrder($orderId) {
		$this->getHelperCommon()->open('/order/view/order_id/'.$orderId.'/');
	}

	/**
	 * Open address info
	 *
	 * @return void
	 */
	public function openAddressInfo() {
		$this->getHelperCommon()->open('/customer/address/');
	}

	/**
	 * Login
	 *
	 * @param string $username
	 * @param string $password
	 */
	public function login($username=NULL, $password=NULL) {
		if (is_null($username) || is_null($password)) {
			$username = $this->getConfiguration()->getValue('testing.frontend.user');
			$password = $this->getConfiguration()->getValue('testing.frontend.password');
		}
		$this->openSplitLoginOrRegister();
		//$this->getHelperCommon()->click("//ul[@class='links personal-items']/li[@class='first']/a");
		$this->getHelperCommon()->type("//input[@id='email']", $username, true, true);
		$this->getHelperCommon()->type("//input[@id='pass']", $password, true, true);
		$this->getHelperCommon()->click("//button[@id='send2']");

		$this->getHelperAssert()->assertBodyClass('customer-account-index');
	}

	/**
	 * Got to forgot password page
	 *
	 * @return void
	 */
	public function openForgotPassword() {
		$this->getHelperCommon()->open('/customer/account/forgotpassword/');
	}

	/**
	 * Logout via open
	 */
	public function logoutViaOpen() {
		$this->getHelperCommon()->open('/customer/account/logout/');
	}

	/**
	 * Create new mail address
	 *
	 * @param string $type
	 * @return mixed
	 * @throws Exception
	 */
	public function createNewMailAddress($type='') {
		if (!$this->getConfiguration()->issetKey('testing.newmailaddresspattern')) {
			throw new Exception('No configuration for testing.newmailaddresspattern found');
		}
		$template = $this->getConfiguration()->getValue('testing.newmailaddresspattern');
		$replace = array(
			'###TYPE###' => $type,
			'###RANDOM###' => Menta_Util_Div::createRandomString(4),
			'###TIME###' => time(),
			'###TESTID###' => $this->getTest()->getTestId()
		);
		return str_replace(array_keys($replace), array_values($replace), $template);
	}

	/**
	 * Create random password
	 *
	 * @param int $length
	 * @return string
	 */
	public function createRandomPassword($length=8) {
		return Menta_Util_Div::createRandomString($length);
	}

	/**
	 * Create random name
	 *
	 * @param int $length
	 * @return string
	 */
	public function createRandomName($length = 8) {
		$name = Menta_Util_Div::createRandomString($length, 'abcdefghijklmnopqrstuvwxyz');
		return ucfirst($name);
	}

	/**
	 * Open registration page
	 */
	public function openRegistrationPage() {
		$this->getHelperCommon()->open('/customer/account/create/');
		$this->getHelperAssert()->assertBodyClass('customer-account-create');
	}

	/**
	 * Populate registration form
	 *
	 * @param array $userAccount
	 */
	public function populateRegistrationForm(array $userAccount) {
		// populate form
		foreach ($userAccount as $field => $value) {
			$this->getHelperCommon()->type('id='.$field, $value, true, true);
		}
	}

	/**
	 * Submit registration form
	 */
	public function submitRegistrationForm() {
		$this->getHelperCommon()->click('//button[@title="Submit"]');
	}

}