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
 * Class definition file for accessor factory. Creates accessors for row objects.
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-09
 *
 */



/**
 * Inclusion of external resources
 */
require_once t3lib_extMgm::extPath('pt_tools').'res/abstract/class.tx_pttools_iSingleton.php'; // interface for Singleton design pattern
require_once t3lib_extMgm::extPath('pt_tools').'res/abstract/class.tx_pttools_iSingletonCollection.php'; // interface for Singleton collection
require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_debug.php'; // debugging class with trace() function
require_once t3lib_extMgm::extPath('pt_tools').'res/objects/class.tx_pttools_exception.php'; // general exception class

/* TODO put that into accessor loading mechanism so that extensions can have their own accessors! */
require_once t3lib_extMgm::extPath('pt_objectstorage').'res/objects/class.tx_ptobjectstorage_t3rowAccessor.php';



/**
 * Accessor factory for creating accessors for row objects
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-09
 */
class tx_ptobjectstorage_accessorFactory implements tx_pttools_iSingletonCollection {
	
	
	
	/**
	 * Holds an array of accessor instances that sould only be instantiated once
	 * 
	 * @var array
	 */
	protected static $accessorUniqueInstances = array();
	
	
	
	/**
	 * Returns a accessor object for a given accessor class name
	 * 
	 * @param	string	@objectId		Name of rowObject to create accessor for
	 * @return 	tx_pttools_rowAccessor	row accessor object
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-03-09
	 * 
	 * @see res/abstract/tx_pttools_iSingletonCollection#getObjectById()
	 */
	public static function getInstanceById($objectId) {
		
		if (array_key_exists($objectId, self::$accessorUniqueInstances)) {
			if (!is_subclass_of(self::$accessorUniqueInstances[$objectId], 'tx_ptobjectstorage_rowAccessor')) {
				throw new tx_pttools_exceptionAssertion("Internal error", "Object should be of type tx_ptobjectstorate_rowAccessor!");
			}
			return self::$accessorUniqueInstances[$objectId];
		} else {
			/* Set default T3 table accessor */
			$accessorClassName = 'tx_ptobjectstorage_t3rowAccessor';
			/* Look up row accessor for corresponding row object */
			if ( is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_objectstorage']['classes'][$objectId]) &&
				array_key_exists('accessor', $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_objectstorage']['classes'][$objectId])) {
				$accessorClassName = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_objectstorage']['classes'][$objectId]['accessor'];
			} 
			/* Create accessor for corresponding row object */
			$accessorObject = new $accessorClassName($objectId); 
			if (!is_subclass_of($accessorObject, 'tx_ptobjectstorage_rowAccessor')) {
				throw new tx_pttools_exceptionAssertion("Internal error", "Object should be of type tx_ptobjectstorate_rowAccessor!");
			}
			self::$accessorUniqueInstances[$objectId] = $accessorObject;
			return self::$accessorUniqueInstances[$objectId];
		}
		
	}
	
	
	
	/**
	 * Make sure, clone() makes no copy of instance
	 * 
	 * @see res/abstract/tx_pttools_iSingleton#__clone()
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-09
	 */
	public function __clone() {
		throw new tx_pttools_exceptionInternal('Cannot instantiate static class!');
	}
	
	
	
	/**
     * Make sure, clone() makes no copy of instance
     * 
     * @see res/abstract/tx_pttools_iSingleton#__clone()
     * @author Michael Knoll <knoll@punkt.de>
     * @since 2009-03-09
     */
	public function __construct() {
		throw new tx_pttools_exceptionInternal('Cannot instantiate static class!');
	}
	
	
	
}

 
?>