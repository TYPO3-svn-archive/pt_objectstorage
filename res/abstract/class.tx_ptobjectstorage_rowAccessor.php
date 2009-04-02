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
 * Class definition file for abstract row accessor
 *
 * $Id: class.tx_ptobjectstorage_rowAccessor.php,v 1.2 2009/03/16 10:52:01 ry21 Exp $
 *
 * @author  Michael Knoll <knoll@punkt.de>
 * @since   2009-02-19
 */ 
 


/**
 * Abstract class for row accessor. 
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-02-19
 */
abstract class tx_ptobjectstorage_rowAccessor {
	
	
	
	/**
	 * Configuration array for rowAccessor. Contains all configuration
	 * for accessor like DSN, table name etc.
	 * 
	 * @var array
	 */
	protected $conf;
	
	
	
	/**
	 * If 'true', accessor can only be used for read-access
	 * 
	 * @var boolean
	 */
	protected $isReadOnlyAccessor;
	
	
	
	/**
	 * Constructor for row accessor
	 * 
	 * @param 	string	$rowObjectClassName		Name of row object class, accessor should be generated for
	 * @param	bool	$isReadOnlyAccessor		Flag, whether accessor is a readonly accessor
	 * @return 	void
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function __construct($rowObjectClassName, $isReadOnlyAccessor = false) {
		
		$this->rowObjectClassName = $rowObjectClassName;
		/* Try to load conf from GLOBALS */
		if (array_key_exists($rowObjectClassName, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_objectstorage']['classes'])) {
			$conf = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_objectstorage']['classes'][$rowObjectClassName];
			$this->conf = $conf;
		} else {
			$this->conf = array();
		}
		$this->isReadOnlyAccessor = $isReadOnlyAccessor;
		
	}

	
	
	/**
	 * Inserts a row object into storage
	 * 
	 * @param 	pt_objectstorage_rowObject	$rowObject	Row object to be inserted
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	abstract public function insertRowObject($rowObject);

	
	
	/**
	 * Updates a row object in storage
	 * 
	 * @param 	pt_objectstorage_rowObject	$rowObject	Row object to be updated
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	abstract public function updateRowObject($rowObject);
	
	
	
	/**
	 * Deletes a row object in storage
	 * 
	 * @param 	pt_objectstorage_rowObject	$rowObject	Row object to be deleted
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	abstract public function deleteRowObject($rowObject);
	
	
	
	/**
	 * Selects row data by a given row UID
	 * 
	 * @param 	tx_ptobjectstorage_rowObject	$rowObject	row object to select data for
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	abstract public function selectRowDataForObject($rowObject);
	
	
	
	/**
	 * Inserts row data into storage, returns UID of inserted row
	 * 
	 * @param 	array	$rowDataArray	Array of data to be inserted
	 * @return 	int						UID of inserted row
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	abstract public function insertRowData($rowDataArray);
	
	
	
	/**
	 * Updates a row by a given row uid and an array of data
	 * 
	 * @param 	int		$rowUid			UID of row to be updated
	 * @param 	array	$rowDataArray	Array of key => value to update row
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	abstract public function updateRowData($rowUid, $rowDataArray);
	
	
	
	/**
	 * Deletes a row, identified by $uid
	 * 
	 * @param 	int		$rowUid	UID of the row that should be deleted
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	abstract public function deleteRow($rowUid);
	
	
	
	/**
	 * Returns value of $isReadonlyAccessor
	 * 
	 * @return 	boolean		True, if accessor is read only
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function isReadOnlyAccessor() {
		return $this->isReadOnlyAccessor;
	}
	

} 


 
?>