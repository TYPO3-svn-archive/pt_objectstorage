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
 * Testsuite for object storage query class
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @since 2009-04-03
 *
 */



/**
 * Inclusion of external ressources
 */
require_once(t3lib_extMgm::extPath('phpunit').'class.tx_phpunit_testcase.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_query.php');



/**
 * Testcase for class "tx_ptobjectstorage_query"
 * 
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-04-03
 */
class tx_ptobjectstorage_query_testcase extends tx_phpunit_testcase {

	
	
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
    	$queryObject = new tx_ptobjectstorage_query();
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    }
    
    
    
    /**
     * Testing for where - setter to work properly
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_where() {
    	$queryObject = new tx_ptobjectstorage_query();
    	$returnValue = $queryObject->where('abc = 123');
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    	$this->assertTrue($queryObject === $returnValue);
    }
    
    
    
    /**
     * Testing for select - setter to work properly
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_select() {
    	$queryObject = new tx_ptobjectstorage_query();
    	$returnValue = $queryObject->select('abc');
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    	$this->assertTrue($queryObject === $returnValue);
    }
    
    
    
    /**
     * Testing for from - setter to work properly
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_from() {
    	$queryObject = new tx_ptobjectstorage_query();
    	$returnValue = $queryObject->from('abc');
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    	$this->assertTrue($queryObject === $returnValue);
    }
    
    
    
    /**
     * Testing for group by - setter to work properly
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_groupBy() {
    	$queryObject = new tx_ptobjectstorage_query();
    	$returnValue = $queryObject->groupBy('abc');
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    	$this->assertTrue($queryObject === $returnValue);
    }
    
    
    
    /**
     * Testing for order by - setter to work properly
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_orderBy() {
    	$queryObject = new tx_ptobjectstorage_query();
    	$returnValue = $queryObject->orderBy('abc');
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    	$this->assertTrue($queryObject === $returnValue);
    }
    
    
    

	/**
     * Testing for limit - setter to work properly
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_limit() {
    	$queryObject = new tx_ptobjectstorage_query();
    	$returnValue = $queryObject->limit('1');
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    	$this->assertTrue($queryObject === $returnValue);
    }
    
    
    
	/**
     * Testing for query generation 
     * 
     * @return  void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-03
     */
    public function test_getSqlQuery() {
    	$queryObject = new tx_ptobjectstorage_query();
    	$returnValue = $queryObject->select('*')
    							   ->from('fe_users')
    							   ->where('uid = 1')
    							   ->limit(10)
    							   ->orderBy('abc')
    							   ->groupBy('abc');
    	$this->assertTrue(is_a($queryObject, 'tx_ptobjectstorage_query'));
    	$query = $queryObject->getSqlQuery();
    	$this->assertTrue($query != '');
    }
    
    
}


?>