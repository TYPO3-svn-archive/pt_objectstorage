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
 * Testsuite for object repository
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @since 2009-04-03
 *
 */



/**
 * Inclusion of external ressources
 */
require_once(t3lib_extMgm::extPath('phpunit').'class.tx_phpunit_testcase.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_rowObjectCollection.php');



/**
 * Testcase for class "tx_ptobjectstorage_repository"
 * 
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-04-03
 */
class tx_ptobjectstorage_rowObjectCollection_testcase extends tx_phpunit_testcase {

	
	
	/**
	 * Setting up the fixture for the tests.
	 * This will be called before each single test
	 * 
	 * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
	 */
	protected function setUp() {

	}

	
	
	/**
	 * Cleaning up after each single test
	 *
	 * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
	 */
	protected function tearDown() {

	}
	
	
	
    /***************************************************************************
     * TEST METHODS
     **************************************************************************/
		
    
    
	/**
	 * Testing for constructor to work properly
	 *
	 * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
	 */
    public function test_construct() {
    	
		$rowObjectCollection = new tx_ptobjectstorage_rowObjectCollection();
		print_r($rowObjectCollection);
		$this->assertTrue(get_class($rowObjectCollection) =='tx_ptobjectstorage_rowObjectCollection');    	
    }
    
        
    
}


?>