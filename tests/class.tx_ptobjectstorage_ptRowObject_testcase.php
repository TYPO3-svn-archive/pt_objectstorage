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
 * Testsuite for ptRowObject
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-11
 *
 */



/**
 * Inclusion of external ressources
 */
require_once(t3lib_extMgm::extPath('phpunit').'class.tx_phpunit_testcase.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_accessorFactory.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'tests/mocks/class.static_countries.php');


/**
 * Testcase for class "tx_ptobjectstorage_ptRowObject"
 * 
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-03-11
 */
class tx_ptobjectstorage_ptRowObject_testcase extends tx_phpunit_testcase {

	
	
	/**
	 * Setting up the fixture for the tests.
	 * This will be called before each single test
	 * 
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-11
	 */
	protected function setUp() {

	}

	
	
	/**
	 * Cleaning up after each single test
	 *
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-11
	 */
	protected function tearDown() {

	}
	
	
	
    /***************************************************************************
     * TEST METHODS
     **************************************************************************/

	
	
	/**
	 * Simple test to check for correct setup 
	 *  
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
	 */
	public function test_constructor() {
		$staticCountryRowObject = new static_countries();
		$this->assertTrue(get_class($staticCountryRowObject) == 'static_countries');
		
	}
	
	
	
	/**
	 * Checking for correct construction functionality of row object
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
	 */
    public function test_rowObjectConstruction() {
    	$staticCountryRowObject = new static_countries(2);
    	$this->assertTrue($staticCountryRowObject->get_cn_iso_2() == 'AE');
    }
    
    
    
    public function test_rowObjectConstructionWithUidCols() {
    	$staticCountryRowObject = new static_countries(array('uid' => 2, 'cn_iso_2' => 'AE'));
    	$this->assertTrue($staticCountryRowObject->get_cn_iso_2() == 'AE');    	
    }
    
    
    
    /**
	 * Checking for correct construction functionality of row object
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
	 */
    public function test_getSet() {
    	$staticCountryRowObject = new static_countries(2);
    	$staticCountryRowObject->set_cn_iso_3('ADD');
    	$testValue = $staticCountryRowObject->get_cn_iso_3();
    	$this->assertTrue(
    		$testValue == 'ADD',
    		'cn_iso_3 should have changed to ADD but was ' . $testValue
    	);
    }
    
    
    
    /**
	 * Checking for correct construction functionality of row object
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
	 */
    public function test_insertAndDelete() {
    	$staticCountryRowObject = new static_countries();
    	$staticCountryRowObject->set_cn_iso_3('xyz');
    	$staticCountryRowObject->set_cn_iso_2('xy');
    	$newStaticCountryUid = $staticCountryRowObject->save();
    	$this->assertTrue(
    		$newStaticCountryUid > 0,
    		'New UID should be > 0 but was ' . $newStaticCountryUid
    	);
    	#print_r($newStaticCountryUid);
    	$staticCountryRowObjectNew = new static_countries($newStaticCountryUid);
    	#print_r($staticCountryRowObjectNew);
    	$this->assertTrue(
    		$staticCountryRowObjectNew->get_cn_iso_3() == 'xyz',
    		'cn_iso_3 should be xyz but was ' . $staticCountryRowObjectNew->get_cn_iso_3()
    	);
    	$this->assertTrue(
    		$staticCountryRowObjectNew->get_cn_iso_2() == 'xy',
    		'cn_iso_2 should be xy but was ' . $staticCountryRowObjectNew->get_cn_iso_2()
    	);
    	$staticCountryRowObjectNew->delete();
    }
    
    
    
    /**
	 * Checking for correct construction functionality of row object
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
	 */
    public function test_updateRowObject() {
    	$staticCountryRowObject = new static_countries(2);
    	$staticCountryRowObject->set_cn_iso_3('ARR');
    	$staticCountryRowObject->save();
    	$staticCountryRowObjectNew = new static_countries(2);
    	$testValue = $staticCountryRowObjectNew->get_cn_iso_3();
    	$this->assertTrue(
    		$testValue == 'ARR',
    		'cn_iso_3 should have changed to ARR but was ' . $testValue
    	);
    	$staticCountryRowObjectNew->set_cn_iso_3('ARE');
    	$staticCountryRowObjectNew->save();
    }
    
    
    
    /**
     * Checking for exception on getting non-available fieldvalues
     * 
     * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
     */
    public function test_nonesenseFieldname() {
    	$this->setExpectedException('tx_pttools_exceptionInternal');
    	$staticCountryRowObject = new static_countries(1);
    	$nonesenseValue = $staticCountryRowObject->get_oweriuqoweiru();
    }    
    
    
    
    /**
     * Checking for exception on wrong UID as constructor parameter
     * 
     * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
     */
    public function test_wrongUidException() {
    	$this->setExpectedException('tx_pttools_exceptionInternal');
    	$staticCountryRowObject = new static_countries(100000, true);
    	$staticCountryRowObject->get_cn_iso_3();
    }
    
    
    public function test_wrongUidNewEntryException() {
    	
    }
    
    
}


?>