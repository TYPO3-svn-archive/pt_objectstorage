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
 * Class definition file for MySql accessor (default accessor)
 *
 * $Id: class.tx_ptobjectstorage_mysqlAccessor.php,v 1.1 2009/03/09 10:13:03 ry21 Exp $
 *
 * @author  Michael Knoll <knoll@punkt.de>
 * @since   2009-02-19
 */ 
 


/**
 * MySql Database row accessor class
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-02-19
 */
class tx_ptobjectstorage_mysqlAccessor extends tx_ptobjectstorage_rowAccessor {
	
	
	/**
	 * Database connection object
	 * 
	 * @var tx_ptobjectstorage_mysqlDatabaseConnector
	 */
	protected $dbObj;
	
	
	
	public function __construct($conf) {
		
		/* Set config in parent constructor */
		parent::__construct($conf, false);
		
		/* Try to set dsn */
		if (!array_key_exists('dsn', $this->conf)) {
			$this->dsn == '';
		} else {
			$this->dsn = $this->conf['dsn'];
		}
		
		/* Init db object */
		if ($this->dsn == '') {
			
			/* Use T3 db object for database access */
			$this->dbObj = $GLOBALS['TYPO3_DB'];
			
		} else {
			
			/* Use external MySql database connector */
			require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/class.tx_ptobjectstorage_mysqlDatabaseConnector.php';
			$this->dbObj = new tx_ptobjectstorage_mysqlDatabaseConnector($this->dsn);
			
		}
		
	}
	

	
	/**
	 * Inserts a row object into storage
	 * 
	 * @param 	tx_ptobjectstorage_rowObject	$rowObject	Row object to be inserted
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function insertRowObject($rowObject) {
		
		$rowUid = $this->insertRowData($rowObject->exportPropertiesToArray());
		return $rowUid;
				
	}

	
	
	/**
	 * Updates a row object in storage
	 * 
	 * @param 	tx_ptobjectstorage_rowObject	$rowObject	Row object to be updated
	 * @return 	void 
	 * @todo	Perhaps return UID of updated row?
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function updateRowObject($rowObject) {
		
		$this->updateRowData(
			$rowObject->getUid(),
			$rowObject->exportPropertiesToArray()
		); 
		
	}
	
	
	
	/**
	 * Deletes a row object in storage
	 * 
	 * @param 	tx_ptobjectstorage_rowObject	$rowObject	Row object to be deleted
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function deleteRowObject($rowObject) {
		
		$this->deleteRow($rowObject->getUid());
		
	}
	
	
	
	/**
	 * Selects row data by a given row UID
	 * 
	 * @param 	int		$rowUid		UID of row to be selected
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function selectRowData($rowUid) {
		
		tx_pttools_assert::isTrue(
			$rowUid > 0, 
			array('message' => '$rowUid should be > 0 but was "' . $rowUid .'"')
		);
		
		tx_pttools_assert::isNotEmptyString(
			$this->conf['table'],
			array('message' => '$this->conf[table] should be non-empty but was empty!')
		);
		
		$tableName = $this->conf['table'];
		
		/* Prepare query */
        $select = '*';
        $from = $tableName;
        $where = 'uid = ' . intval($rowUid) . ' ' . tx_pttools_div::enableFields($from);
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        
        /* exec query using current db object */
        $res = $this->dbObj->exec_SELECTquery($select, $from, $where, $groupBy, $orderBy, $limit);
        tx_pttools_assert::isMySQLRessource($res);
        $a_row = $this->dbObj->sql_fetch_assoc($res);
        $this->dbObj->sql_free_result($res);
        trace($a_row);
        
        return $a_row;
		
	}
	
	
	
	/**
	 * Inserts row data into storage, returns UID of inserted row
	 * 
	 * @param 	array	$rowDataArray	Array of data to be inserted
	 * @return 	int						UID of inserted row
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function insertRowData($rowDataArray) {
		
		tx_pttools_assert::isNotEmptyString(
			$this->conf['table'],
			array('message' => '$this->conf[table] should be non-empty but was empty!')
		);
		$tableName = $this->conf['table'];
		trace('[METHOD] ' . __METHOD__);
        trace($row, 0, '$row');
        $res = $this->dbObj->exec_INSERTquery($tableName, $rowDataArray);
        tx_pttools_assert::isMySQLRessource($res);
        trace($res);
        $this->dbObj->sql_free_result($res);
        
        return $this->dbObj->sql_insert_id();
		
	}
	
	
	
	/**
	 * Updates a row by a given row uid and an array of data
	 * 
	 * @param 	int		$rowUid			UID of row to be updated
	 * @param 	array	$rowDataArray	Array of key => value to update row
	 * @return 	void 
	 * @todo 	Perhaps UID of updated record should be returned?
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function updateRowData($rowUid, $rowDataArray) {
		
		tx_pttools_assert::isNotEmptyString(
			$this->conf['table'],
			array('message' => '$this->conf[table] should be non-empty but was empty!')
		);
		$tableName = $this->conf['table'];
		trace('[METHOD] ' . __METHOD__);
        $where = 'uid =' . intval($rowUid);
        $res = $this->dbObj->exec_UPDATEquery($tableName, $where, $row);
        tx_pttools_assert::isMySQLRessource($res);
        $this->dbObj->sql_free_result($res);
		
	}
	
	
	
	/**
	 * Deletes a row, identified by $uid
	 * 
	 * @param 	int		$rowUid	UID of the row that should be deleted
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function deleteRow($rowUid) {
		
		tx_pttools_assert::isNotEmptyString(
			$this->conf['table'],
			array('message' => '$this->conf[table] should be non-empty but was empty!')
		);
		$tableName = $this->conf['table'];
        $where = 'uid' . intval($rowUid);
        $res = $this->dbObj->exec_DELETEquery($tableName, $where);
        tx_pttools_assert::isMySQLRessource($res);
        $this->dbObj->sql_free_result($res);
		
	}
	
	
	
}
 
?>