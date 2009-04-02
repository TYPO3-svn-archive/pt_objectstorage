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
 * Class definition file for object repository
 *
 * $Id: class.tx_ptobjectstorage_objectRepository.php,v 1.1 2009/03/09 10:13:03 ry21 Exp $
 *
 * @author  Michael Knoll <knoll@punkt.de>
 * @since   2009-02-19
 */ 



/**
 * Inclusion of required ressources
 */
require_once t3lib_extMgm::extPath('pt_tools') . 'res/objects/class.tx_pttools_exception.php';
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/staticlib/tx_ptobjectstorage_accessorFactory.php';


 
 /**
  *
  * @author Michael Knoll <knoll@punkt.de>
  * @package TYPO3
  * @subpackage pt_objectstorage
  * @since 2009-02-19
  */
 class tx_ptobjectstorage_objectRepository {
 
 	
 	
 	/**
 	 * Stores a given object into whatever storage
 	 * 
 	 * @param 	tx_ptobjectstorage_rowObject	$object		Object to store in storage
 	 * @return 	mixed
 	 */
 	public function storeObject($object) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 	
 	/**
 	 * Creates an object from storage identified by class name and row uid
 	 * 
 	 * @param 	string	$className	Name of class to be instanciated
 	 * @param 	int		$uid		UID of row object to be returned
 	 * @return 	tx_ptobjectstorage_rowObject	Requested object from storage
 	 */
 	public function getObject($className, $uid) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 	
 	/**
 	 * Returns a object collection of row objects for a given 
 	 * class name and an array of UIDs
 	 * 
 	 * @param 	string	$className		Name of class of objects to be returned
 	 * @param 	array	$uids			Array of UIDs to be returned
 	 * @return 	tx_pttools_objectCollection	Collection of requested objects
 	 */
 	public function getObjectCollection($className, $uids) {
 		// TODO von welchem Typ soll Objekt sein, das hier zurückgegeben wird?
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 
 }
 
 ?>