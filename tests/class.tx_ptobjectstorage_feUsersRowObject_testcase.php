<?php

/***************************************************************
*  Copyright notice
*  
*  (c) 2005-2009 Michael Knoll (knoll@punkt.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/



/**
 * Testsuite for fe users row object
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-13
 *
 */



/**
 * Inclusion of external ressources
 */
require_once(t3lib_extMgm::extPath('phpunit').'class.tx_phpunit_testcase.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/examples/class.tx_ptobjectstorage_feUsersRowObject.php');



/**
 * Testcase for class "tx_ptobjectstorage_genericRowObject"
 * 
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-03-13
 */
class tx_ptobjectstorage_feUsersRowObject_testcase extends tx_phpunit_testcase {

	
	
	/**
	 * Holds a reference to a generic row object
	 * @var tx_ptobjectstorage_genericRowObject
	 */
	protected $feUsersRowObject;
	
	
	
	/**
	 * Setting up the fixture for the tests.
	 * This will be called before each single test
	 * 
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-13
	 */
	protected function setUp() {
		// Constructor is tested below!
		$this->feUsersRowObject = new tx_ptobjectstorage_feUsersRowObject();
	}

	
	
	/**
	 * Cleaning up after each single test
	 *
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-13
	 */
	protected function tearDown() {

	}
	
	
	
    /***************************************************************************
     * TEST METHODS
     **************************************************************************/

	public function test_construct() {
		$feUsersRowObject = new tx_ptobjectstorage_feUsersRowObject();
		$this->assertTrue(get_class($feUsersRowObject) == 'tx_ptobjectstorage_feUsersRowObject');
	}
	
    
}


?>