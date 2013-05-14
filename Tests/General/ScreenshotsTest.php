<?php

require_once dirname(__FILE__).'/../TestcaseAbstract.php';

class Acceptance_Tests_General_ScreenshotsTest extends Acceptance_Tests_TestcaseAbstract {

	/**
	 * Create screenshots
	 *
	 * @test
	 * @return void
	 * @author Fabrizio Branca
	 * @since 2012-11-15
	 */
	public function screenshots() {
		$this->getHelperCommon()->open('/');
		$this->takeScreenshot('Home page');
	}


}