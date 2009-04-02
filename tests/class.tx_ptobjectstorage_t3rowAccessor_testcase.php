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
 * Testsuite for T3 row accessor
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
require_once(t3lib_extMgm::extPath('pt_objectstorage').'tests/mocks/class.static_countries.php');


/**
 * Testcase for class "tx_ptobjectstorage_t3rowAccessor"
 * 
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-03-09
 */
class tx_ptobjectstorage_t3rowAccessor_testcase extends tx_phpunit_testcase {

	
	
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
	
	
	
    public function test_construct() {
    	$rowAccessor = new tx_ptobjectstorage_t3rowAccessor('static_countries');
    	$this->assertTrue(is_a($rowAccessor,'tx_ptobjectstorage_t3rowAccessor'),
    		'$rowAccessor object should be of tx_ptobjectstorage_t3rowAccessor type, but was of type ' . gettype($rowAccessor));
    }

    
    
    public function test_nonesenseTable() {
    	$this->setExpectedException('tx_pttools_exceptionConfiguration');
    	$rowAccessor = new tx_ptobjectstorage_t3rowAccessor('xyz192873');
    }
    
    
    
    public function test_rowObjectConstruction() {
    	$staticCountryRowObject = new static_countries(1);
    	$this->assertTrue($staticCountryRowObject->get_cn_iso_2() == 'AD');
    }
    
    
}


?>