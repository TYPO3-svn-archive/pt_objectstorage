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
 * Abstract class implementing a row object as used at punkt.de
 *
 * $Id: class.tx_ptobjectstorage_ptRowObject.php,v 1.10 2009/03/18 13:34:35 ry21 Exp $
 * 
 * @package		TYPO3
 * @subpackage	tx_pttools
 * @author  	Michael Knoll <knoll@punkt.de>
 * @since   	2009-03-11
 */ 
 


/**
 * Include required ressources
 */
require_once(t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/class.tx_ptobjectstorage_accessorFactory.php');
require_once(t3lib_extMgm::extPath('pt_objectstorage') . 'res/abstract/class.tx_ptobjectstorage_rowObject.php');
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/class.tx_ptobjectstorage_ptRowObjectFactory.php';



/**
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package Typo3
 * @subpackage pt_tools
 * @since 2009-03-11
 * 
 */
abstract class tx_ptobjectstorage_ptRowObject extends tx_ptobjectstorage_rowObject {

	
	
	/**
	 * Holds a reference to the row accessor for static countries
	 * 
	 * @var tx_ptobjectstorage_rowAccessor
	 */
	protected $rowAccessor;
	
	
	
	/**
	 * Set to true, if row has not been inserted into database yet
	 * 
	 * @var bool
	 */
	protected $isNewRow;
	
	
	
	/**
	 * Holds tablename of corresponding database table
	 * 
	 * @var string
	 */
	protected $tableName = '';
	
	
	
	/**
	 * Constructor for pt row object.
	 * 
	 * If uid is != '', accessor is used to load object data from database
	 * 
	 * @param 	mixed	$uid						array with (rowUidColumn => rowUidValue) or scalar rowUid value
	 * @param	bool	$throwExceptionOnFalseUid	If set to true, an exception will be thrown, if no record can be found for given UID
	 * @return 	void
	 * @author Michael Knoll <knoll@punkt.de>
	 * @since 2009-03-11
	 */
	public function __construct($rowUids = 0, $throwExceptionOnFalseUid = false) {

		parent::__construct($rowUids);
		
		/* init row accessor (template method) */
		$this->initRowAccessor();
		
		// @todo UID beim schreiben setzen, falls throwException auf false Flag newRow nochmal �berdenken!

		/**
		 * 2 posibilities:
		 * 
		 * 1. rowUids is an array, than look for values inside array and try to load row object
		 * 2. rowUids is a scalar, than load row object by setting up the uidCols Array and field value
		 */
		$uidValuesSet = true;
		foreach ($this->uidColNames as $uidColName) {
			if (array_key_exists($uidColName, $this->fieldValueArray) 
				&& $this->fieldValueArray[$uidColName] == '') {
				
				$uidValuesSet = false;
				
			}
			if (!array_key_exists($uidColName, $this->fieldValueArray)) {
				
				$uidValuesSet = false;
				
			}
		} 
		if ($uidValuesSet) {
			
			/* load row from database */
			$rowDataArray = $this->rowAccessor->selectRowDataForObject($this);
			if (is_array($rowDataArray) && sizeof($rowDataArray) > 0 ) {
				$this->setPropertiesFromArray($rowDataArray);
			} elseif ($throwExceptionOnFalseUid) {
				/* No record found for UID and should throw exception */
				throw new tx_pttools_exceptionInternal(
					'Wrong UID, no record could be found for given UID!',
					'Wrong UID ' . $uid . ' no record could be found!'
				);
			} else {
				throw new tx_pttools_exceptionInternal(
					'Invalid UID!',
					'Trying to set UID that is not yet existing in row object that has no uid field in available fields! UID: ' . $uid
				);
			}
			
			$this->isNewRow = false;
			
		} else {
			
			/* Row has not been inserted yet */
			$this->isNewRow = true;
			
		}
		
	}
	
	
	
	/**
	 * Saves object to database.
	 * 
	 * @return 	mixed	UID of database record
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-11
	 */
	public function save() {
		
		if ($this->isNewRow) {
			$this->rowUid = $this->rowAccessor->insertRowObject($this);
			$this->isNewRow = false;
		} else {
			$this->rowAccessor->updateRowObject($this);
		}
		
		return $this->rowUid;
		
	}
	
	
	/**
	 * Deletes object (from database if it's already inserted)
	 * 
	 * @return 	bool	True, if object was deleted from database
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-11
	 */
	public function delete() {
		
		if (!$this->isNewRow) {
			$this->rowAccessor->deleteRowObject($this);
			$deleted = true;
		}
		$this->fieldValueArray = array();
		return $deleted;
		
	}
	
	
	
	/**
	 * Default method for initialization of row accessor.
	 * 
	 * Overwrite this method to change functionality of row accessor initialization
	 * 
	 * @return 	void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	protected function initRowAccessor() {
		
		if ($this->tableName != '') {
			$accessorTableName = $this->tableName;
		} else {
			$accessorTableName = get_class($this);
		}
		
		$this->rowAccessor = tx_ptobjectstorage_accessorFactory::getInstanceById($accessorTableName);
		
	}


	
	/**
	 * TODO Test this 
	 * Experimental!
	 */
	public static function getInstanceByRepositoryParams($params) {
		
		$rowObject = parent::getInstanceByRepositoryParams($params);
		$rowObject->isNewRow = false;
		$rowAccessor = $params['accessor'];
		$tableName = $params['table_name'];
		return $rowObject;
		
	}
	

	
}
 
?>