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
 * Class definition file for row object factory class
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @since 2009-04-05
 *
 */



/**
 * Inclusion of external ressources
 */
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/abstract/class.tx_ptobjectstorage_rowObject.php';
require_once t3lib_extMgm::extPath('pt_tools') . 'res/abstract/class.tx_pttools_iSingleton.php';



/**
 * Factory for row objects
 * 
 * IMPORTANT: This class needs to extend tx_ptobjectstorage_rowObject, as it modifies 
 * protected properties of this class!
 * 
 * @package 	TYPO3
 * @subpackage 	pt_objectstorage
 * @author 		Michael Knoll <knoll@punkt.de>
 * @since 		2009-04-05
 *
 */
class tx_ptobjectstorage_rowObjectFactory extends tx_ptobjectstorage_rowObject { 

	
	
	/**
	 * @var tx_ptobjectstorage_rowObject 	Instance variable for singleton implementation
	 */
	protected static $instance;
	
	
	
	/**
	 * Factory method for singleton instance
	 * 
	 *  @return 	tx_ptobjectstorage_rowObjectFactory		Singleton instance of row object factory
	 *  @author		Michael Knoll <knoll@punkt.de>
	 *  @since		2009-04-05
	 */
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new tx_ptobjectstorage_rowObjectFactory;
		}
		return self::$instance;
	}

	
	
	/**
	 * Empty constructor overwriting default row object constructor
	 * 
	 * @return 	void
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-05
	 */
	public function __construct() {
		
	}
	
	
	
	
	/**
	 * Overwrite clone() method to avoid cloning
	 * 
	 * @return 	void
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-05
	 */
	public function __clone() {
		throw new Exception('Cannot be cloned!');
	}
	
	
	
	/**
	 * Create new instance of row object for a given set of parameters
	 * 
	 * @param	array	$params					Set of parameters 
	 * @return	tx_ptobjectstorage_rowObject	Generated row object
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-05
	 */
	public static function getInstanceByRepositoryParams($params) {
		
		$className = $params['class_name'];
		$rowObject = new $className();
		$rowObject->availableFieldsArray = array_keys($params['row_data']);
		$rowObject->fieldValueArray = $params['row_data'];
		$rowObject->uidColNames = $params['uid_cols'];
		return $rowObject;
		
	}
	
	
	
}

?>