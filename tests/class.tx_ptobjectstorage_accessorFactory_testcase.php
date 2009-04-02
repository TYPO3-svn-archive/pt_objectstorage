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
 * Testsuite for object storage checking for correct setup of environment
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-09
 *
 */



/**
 * Inclusion of external ressources
 */
require_once(t3lib_extMgm::extPath('phpunit').'class.tx_phpunit_testcase.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_accessorFactory.php');



/**
 * Testcase for class "tx_pttools_objectCollection"
 * 
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-03-09
 */
class tx_ptobjectstorage_accessorFactory_testcase extends tx_phpunit_testcase {

	
	
	/**
	 * Setting up the fixture for the tests.
	 * This will be called before each single test
	 * 
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-09
	 */
	protected function setUp() {

	}

	
	
	/**
	 * Cleaning up after each single test
	 *
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-09
	 */
	protected function tearDown() {

	}
	
	
	
    /***************************************************************************
     * TEST METHODS
     **************************************************************************/
		
    
    
    public function test_getObjectById() {
    	$staticCountriesAccessor = tx_ptobjectstorage_accessorFactory::getInstanceById('static_countries');
    	$this->assertTrue(is_a($staticCountriesAccessor, 'tx_ptobjectstorage_t3rowAccessor'));
    }
    
    
    
}


?>