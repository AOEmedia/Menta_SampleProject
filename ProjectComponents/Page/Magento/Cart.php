<?php

/**
 * "Cart" PageObject for Magento
 *
 * @author Fabrizio Branca
 * @since 2013-05-13
 */
class ProjectComponents_Page_Magento_Cart extends Menta_Component_AbstractTest {


    /** ****************************************************************************************************************
     * LOCATORS
     **************************************************************************************************************** */




    /** ****************************************************************************************************************
     * URLS
     *****************************************************************************************************************/

    /**
   	 * Get cart url
   	 *
   	 * @return string
   	 */
   	public function getCartUrl() {
   		return '/checkout/cart/';
   	}



    /** ****************************************************************************************************************
     * ASSERTIONS
     **************************************************************************************************************** */

    /**
	 * Check if we're on the cart page.
	 * Useful if e.g. the add to cart button should have redirected to this page
	 *
	 * @author Fabrizio Branca
	 * @since 2012-11-16
	 */
	public function assertOnCartPage() {
		$this->getHelperAssert()->assertBodyClass('checkout-cart-index');
	}

    /**
   	 * Assert that the cart is empty
   	 *
   	 * @return void
   	 */
   	public function assertEmptyCart() {
   		$this->open();
   		$this->getHelperAssert()->assertTextPresent($this->__('Shopping Cart is Empty'));
   	}



    /** ****************************************************************************************************************
     * ACTIONS
     **************************************************************************************************************** */

	/**
	 * Open cart
	 *
	 * @return void
	 */
	public function open() {
		$this->getHelperCommon()->open($this->getCartUrl());
		$this->getHelperAssert()->assertTitle($this->__("Shopping Cart"));
		$this->assertOnCartPage();
	}

}