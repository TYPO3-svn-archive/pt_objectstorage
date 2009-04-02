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
 * Testsuite for generic row object
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-12
 *
 */



/**
 * Inclusion of external ressources
 */
require_once(t3lib_extMgm::extPath('phpunit').'class.tx_phpunit_testcase.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_genericRowObject.php');



/**
 * Testcase for class "tx_ptobjectstorage_genericRowObject"
 * 
 * @author 	Michael Knoll <knoll@punkt.de>
 * @since 	2009-03-12
 */
class tx_ptobjectstorage_genericRowObject_testcase extends tx_phpunit_testcase {

	
	
	/**
	 * Holds a reference to a generic row object
	 * @var tx_ptobjectstorage_genericRowObject
	 */
	protected $genericRowObject;
	
	
	
	/**
	 * Setting up the fixture for the tests.
	 * This will be called before each single test
	 * 
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-09
	 */
	protected function setUp() {
		// Constructor is tested below!
		$this->genericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			#tx_ptobjectstorage_genericRowObject::MANUAL_CONFIG,
			tx_ptobjectstorage_genericRowObject::EXT_LOCALCONF_CONFIG,
			1, 
			false
    	);
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

	
	
	/**
	 * @todo Problem: what happens, if constructor fails? Then all tests will crash and only one problem needs to be fixed without knowing, where to fix it
	 */
	
	
	
    public function test_manualConstruct() {
    	$genericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			tx_ptobjectstorage_genericRowObject::MANUAL_CONFIG,
			1, 
			false, 
    		array('availableFields' => 
	    		array('uid',
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
					'cn_short_de')
	    	)
    	);
    	$this->assertTrue(get_class($genericRowObject) == 'tx_ptobjectstorage_genericRowObject');
    }
    
    
    
	public function test_extLocalconfConstruct() {
    	$genericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			tx_ptobjectstorage_genericRowObject::EXT_LOCALCONF_CONFIG,
			1, 
			false
    	);
    	$this->assertTrue(get_class($genericRowObject) == 'tx_ptobjectstorage_genericRowObject');
    }
    
    
    
	public function test_dbSchemaConstruct() {
    	$genericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			tx_ptobjectstorage_genericRowObject::DB_SCHEMA_CONFIG,
			1, 
			false
    	);
    	$this->assertTrue(get_class($genericRowObject) == 'tx_ptobjectstorage_genericRowObject');
    }
    
    
    
	public function test_tcaConstruct() {
    	$genericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			tx_ptobjectstorage_genericRowObject::TCA_CONFIG,
			1, 
			false
    	);
    	$this->assertTrue(get_class($genericRowObject) == 'tx_ptobjectstorage_genericRowObject');
    }

    
    
    public function test_getSet() {
    	$this->genericRowObject->get_cn_iso_2();
    	$this->assertTrue($this->genericRowObject->get_cn_iso_2() == 'AD');
    	$this->genericRowObject->set_cn_iso_2('AE');
    	$this->assertTrue($this->genericRowObject->get_cn_iso_2() == 'AE');
    	$this->genericRowObject->set_cn_iso_2('AD');
    	$this->assertTrue($this->genericRowObject->get_cn_iso_2()== 'AD');
    }
    
    
    
    public function test_save() {
		$this->genericRowObject->set_cn_iso_2('AE');
		$this->genericRowObject->save();
		// Check for changes
		$newGenericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			tx_ptobjectstorage_genericRowObject::MANUAL_CONFIG,
			1, 
			false, 
    		array('availableFields' => 
	    		array('uid',
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
					'cn_short_de')
	    	)
    	);
    	$this->assertTrue($newGenericRowObject->get_cn_iso_2() == 'AE');
    	// Undo changes
    	$this->genericRowObject->set_cn_iso_2('AD');
    	$this->genericRowObject->save();
    	// Check for undone changes
    	$newGenericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			tx_ptobjectstorage_genericRowObject::MANUAL_CONFIG,
			1, 
			false, 
    		array('availableFields' => 
	    		array('uid',
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
					'cn_short_de')
	    	)
    	);
    	$this->assertTrue($newGenericRowObject->get_cn_iso_2() == 'AD');
    }
    
    
    public function test_dbSchemaConfig() {
    	$newGenericRowObject = new tx_ptobjectstorage_genericRowObject(
    		'static_countries', 
			tx_ptobjectstorage_genericRowObject::DB_SCHEMA_CONFIG
    	);
    }
    
    
}


?>