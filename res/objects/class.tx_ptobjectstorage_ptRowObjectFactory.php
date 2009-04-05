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
 * Inclusion of external sources
 */
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/class.tx_ptobjectstorage_rowObjectFactory.php';



/**
 * Factory for pt row objects
 * 
 * IMPORTANT: This class needs to extend tx_ptobjectstorage_ptRowObject, as it modifies 
 * protected properties of this class!
 * 
 * @package 	TYPO3
 * @subpackage 	pt_objectstorage
 * @author 		Michael Knoll <knoll@punkt.de>
 * @since 		2009-04-05
 *
 */
class tx_ptobjectstorage_ptRowObjectFactory extends tx_ptobjectstorage_RowObjectFactory{

	
	
	/**
	 * Singleton method
	 * 
	 * @return 	tx_ptobjectstorage_prRowObjectFactory	Instance of factory
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-05
	 */
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new tx_ptobjectstorage_ptRowObjectFactory;
		}
		return self::$instance;
	}
	
	
	
	/**
	 * Create new instance of row object for a given set of parameters
	 * 
	 * @param	array	$params					Set of parameters 
	 * @return	tx_ptobjectstorage_ptRowObject	Generated row object
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-05
	 */
	public static function getInstanceByRepositoryParams($params) {
		
		$rowObject = parent::getInstanceByRepositoryParams($params);
		$rowObject->tableName = $params['table_name'];
		return $rowObject;
		
	}
	
	
	
}

?>