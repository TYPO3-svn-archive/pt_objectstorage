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
 * Class definition file for generic row object factory
 *
 * IMPORTANT: This class needs to extend tx_ptobjectstorage_rowObject, as it modifies 
 * protected properties of this class!
 * 
 * $Id:$
 * 
 * @author  	Michael Knoll <knoll@punkt.de>
 * @since   	2009-04-05
 */ 



/**
 * Inclusion of external ressources
 */
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/class.tx_ptobjectstorage_rowObjectFactory.php';



/**
 * Row object factory for generic row objects
 * 
 * @package		TYPO3
 * @subpackage	pt_objectstorage
 * @author  	Michael Knoll <knoll@punkt.de>
 * @since   	2009-04-05
 */
class tx_ptobjectstorage_genericRowObjectFactory extends tx_ptobjectstorage_ptRowObjectFactory{

	
	
	/**
	 * Singleton factory method
	 * 
	 * @return 	tx_ptobjectstorage_genericRowObjectFactory		Singleton instance of row object factory
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-05
	 */
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new tx_ptobjectstorage_genericRowObjectFactory;
		}
		return self::$instance;
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
		
		$rowObject = new tx_ptobjectstorage_genericRowObject(
			$params['table_name'],
			tx_ptobjectstorage_genericRowObject::MANUAL_CONFIG,
			$params['uid_cols'],
			true,
			array(
				'availableFields' => array_keys($params['row_data'])
			)
		);
		$rowObject->setPropertiesFromArray($params['row_data']);
		return $rowObject;
		
	}
	
	
	
}

?>