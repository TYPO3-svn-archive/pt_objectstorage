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
 * Testsuite for tx_ptobjectstorage_rowObject
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-14
 *
 */



/**
 * Inclusion of external ressources
 */
require_once(t3lib_extMgm::extPath('phpunit').'class.tx_phpunit_testcase.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_accessorFactory.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/abstract/class.tx_ptobjectstorage_rowObject.php');


/**
 * Helper class for testing pt_objectstorage_rowObject class
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @since 2009-03-14
 * @package TYPO3
 * @subpackage pt_objectstorage
 *
 */
class tx_ptobjectstorage_rowObject_testcase_helper extends tx_ptobjectstorage_rowObject {
	
	
	
	public function __construct($rowUids = 0) {
		parent::__construct($rowUids);
	}
	
	
	
	/**
	 * Sets the available fields of database table
	 * 
	 * @return void
	 */
	protected function setAvailableFields() {

		$this->availableFieldsArray = array(
			'uid',
			'pid',
			'cn_iso_2',
			'cn_iso_3',
			'cn_iso_nr',
			'cn_parent_tr_iso_nr',
			'cn_official_name_local',
			'cn_official_name_en',
			'cn_capital',
			'cn_tldomain',
			'cn_currency_iso_3',
			'cn_currency_iso_nr',
			'cn_phone',
			'cn_eu_member',
			'cn_address_format',
			'cn_zone_flag',
			'cn_short_local',
			'cn_short_en',
			'cn_uno_member',
			'cn_short_de'		
		);
		
	} 
	
	
	
	/**
	 * Sets array of fields that can't be returned by magic setter
	 * 
	 * @return void
	 */
	protected function setNonSettableFields() {
		
		$this->nonSettableFields = array('uid');
		
	}
	
	
	
	/**
	 * Sample method for setting non-gettable fields
	 * 
	 * @return void
	 */
	protected function setNonGettableFields() {
		$this->nonGettableFields = array('cn_short_en');
	}
	
	
	
	/**
	 * Sample validation method
	 * 
	 * @param 	mixed	$value					Value to be validated
	 * @return 	void
	 * @throws	tx_pttools_exceptionInternal
	 */
	protected function validate_cn_iso_2($value) {
		if (!is_numeric($value)) {
			throw new tx_pttools_exceptionInternal('value should be numeric, but was not numeric!');
		}
	}
	
	
}



/**
 * Testcase for class "tx_ptobjectstorage_rowObject"
 * 
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-03-14
 */
class tx_ptobjectstorage_rowObject_testcase extends tx_phpunit_testcase {

	
	
	/**
	 * Setting up the fixture for the tests.
	 * This will be called before each single test
	 * 
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-11
	 */
	protected function setUp() {
		$this->testArray = array(
			'uid' => '1',
			'pid' => '2',
			'cn_iso_2' => '3',
			'cn_iso_3' => '2',
			'cn_iso_nr' => '2',
			'cn_parent_tr_iso_nr' => '2',
			'cn_official_name_local' => '2',
			'cn_official_name_en' => '2',
			'cn_capital' => '2',
			'cn_tldomain' => '2',
			'cn_currency_iso_3' => '2',
			'cn_currency_iso_nr' => '2',
			'cn_phone' => '2',
			'cn_eu_member' => '2',
			'cn_address_format' => '2',
			'cn_zone_flag' => '2',
			'cn_short_local' => '2',
			'cn_short_en' => '2',
			'cn_uno_member' => '2',
			'cn_short_de' => '2'		
		);
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
		$rowObject  = new tx_ptobjectstorage_rowObject_testcase_helper();
		$this->assertTrue(get_class($rowObject) == 'tx_ptobjectstorage_rowObject_testcase_helper');
		
	}
	
	
	
	/**
	 * Tests the setting and exporting of properties to an array
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_exportPropertiesToArray() {
		$rowObject  = new tx_ptobjectstorage_rowObject_testcase_helper();
		$rowObject->setPropertiesFromArray($this->testArray);
		$isTheSameArray = true;
		foreach ($rowObject->exportPropertiesToArray() as $key => $value) {
			if (!(array_key_exists($key, $this->testArray)) && $this->testArray[$key] == $value) {
				$isTheSameArray = false;
			}
		}
		$this->assertTrue($isTheSameArray);
	}
	

	
	/**
	 * Tests the array access interface of row object
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_arrayAccess() {
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper();
		$rowObject->setPropertiesFromArray($this->testArray);
		$isTheSameArray = true;
		foreach ($this->testArray as $key => $value) {
			if (!$rowObject[$key] == $value) {
				$isTheSameArray = false;
			}
		}
		$this->assertTrue($isTheSameArray);
	}
	
	
	
	/**
	 * Tests for an exception on setting false UID Array in constructor
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_errorOnFalseUidArray() {
		$this->setExpectedException('tx_pttools_exceptionAssertion');
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper(array('1234'));
	}
	
	
	
	/**
	 * Tests magic __call for getting and setting attributes
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_getSet() {
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper();
		$rowObject->setPropertiesFromArray($this->testArray);
		$getterWorks = true;
		
		/* Test getter */
		foreach ($this->testArray as $key => $value) {
			if ($key != 'cn_short_en') {
				if (!call_user_method('get_' . $key, $rowObject) == $value) {
					$getterWorks = false;
				}
			}
		}
		$this->assertTrue($getterWorks);
		
		/* Test setter */
		$setterWorks = true;
		foreach ($this->testArray as $key => $value) {
			if ($key != 'uid' && $key != 'cn_short_en') {
				$methodName = 'set_' . $key;
				$rowObject->$methodName($value . $value);
				if (!call_user_method('get_' . $key, $rowObject) == $value . $value) {
					$setterWorks = false;
				}
			}
		}
		$this->assertTrue($setterWorks);
	}
	
	
	
	/**
	 * Tests setting a non-settable field (should throw an exception)
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_nonSettableFields() {
		$this->setExpectedException('tx_pttools_exceptionInternal');
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper();
		$rowObject->set_uid(12345);
	}
	
	
	
	/**
	 * Tests method to return uid cols and values for a row object
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_getUids() {
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper(array('uid' => '2', 'pk' => '3'));
		$uidCols = $rowObject->getUids();
		$isTheSameArray = true;
		if ($uidCols['uid'] != '2' || $uidCols['pk'] != '3')
			$isTheSameArray = false;
		$this->assertTrue($isTheSameArray);
	}
	
	
	
	/**
	 * Tests method to return uid col names of a row object
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_getUidColNamess() {
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper(array('uid' => '2', 'pk' => '3'));
		$uidCols = $rowObject->getUidColNames();
		$isTheSameArray = true;
		if ($uidCols[0] != 'uid' || $uidCols[1] != 'pk')
			$isTheSameArray = false;
		$this->assertTrue($isTheSameArray);
	}
	
	
	
	/**
	 * Tests for validation of objectRow property setting
	 * 
	 * @return void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-15
	 */
	public function test_validateSetter() {
		$this->setExpectedException('tx_pttools_exceptionInternal');
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper();
		$rowObject->set_cn_iso_2('test');
	}
	
	
	
	public function test_nonGettableFields() {
		$this->setExpectedException('tx_pttools_exceptionInternal');
		$rowObject = new tx_ptobjectstorage_rowObject_testcase_helper();
		$value = $rowObject->get_cn_short_en();
	}
	
	
}


?>