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
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_repository.php');



/**
 * Testcase for class "tx_ptobjectstorage_repository"
 * 
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-04-03
 */
class tx_ptobjectstorage_repository_testcase extends tx_phpunit_testcase {

	
	
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
    	// TODO check for construct to be non-working
    	$this->markTestIncomplete();
    }
    
    
    
    /**
     * Testing for factory method to work properly
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_getInstance() {
    	$repository = tx_ptobjectstorage_repository::getInstance();
    	$this->assertTrue(get_class($repository) == 'tx_ptobjectstorage_repository');
    }
    
    
    
    public function test_gestRowObjectByUid() {
    	$repository = tx_ptobjectstorage_repository::getInstance();
    	$rowObject = $repository->getRowObjectByUid('fe_users', 1);
    	$this->assertTrue($rowObject['uid'] == 1);
    }
    
    
    
    public function test_registerTableClassPath() {
    	$repository = tx_ptobjectstorage_repository::getInstance();
    	$tableName = 'fe_users';
    	$className = 'tx_ptobjectstorage_feUsersRowObject';
    	$classPath = t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/examples/class.tx_ptobjectstorage_feUsersRowObject.php';
    	$repository->registerTableClassPath($tableName, $className, $classPath);
    }
    
    
    
    public function test_getRowObjectByClassNameAndUid() {
		// TODO as this test fails, put configuration for accessors into repository?!?
    	$repository = tx_ptobjectstorage_repository::getInstance();
    	$tableName = 'fe_users';
    	$className = 'tx_ptobjectstorage_feUsersRowObject';
    	$classPath = t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/examples/class.tx_ptobjectstorage_feUsersRowObject.php';
    	$repository->registerTableClassPath($tableName, $className, $classPath);
    	$rowObject = $repository->getRowObjectByClassNameAndUid('tx_ptobjectstorage_feUsersRowObject', 1);
    	$this->assertTrue($rowObject['uid'] == 1);
    }
    
        
    
}


?>