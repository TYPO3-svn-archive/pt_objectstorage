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
 * Class definition file for default Typo3 row accessor
 *
 * $Id: class.tx_ptobjectstorage_t3rowAccessor.php,v 1.9 2009/04/02 10:03:06 ry21 Exp $
 *
 * @author  Michael Knoll <knoll@punkt.de>
 * @since   2009-03-09
 */ 
 


/**
 * Inclusion of external resources
 */
require_once t3lib_extMgm::extPath('pt_objectstorage').'res/abstract/class.tx_ptobjectstorage_rowAccessor.php'; // abstract row accessor class
require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_div.php'; // static helper class



/**
 * Class for default typo3 row accessor. 
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-03-09
 */
class tx_ptobjectstorage_t3rowAccessor extends tx_ptobjectstorage_rowAccessor {

	
	
	/**
	 * Holds the name of the table on which the row accessor operates
	 * 
	 * @var string
	 */
	protected $tableName;
	
	
	
	/**
	 * Holds a reference to the T3 Database Object
	 * 
	 * @var t3lib_db
	 */
	protected $dbObj;
	

	
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
		
		parent::__construct($rowObjectClassName, $isReadOnlyAccessor);
		
		$this->dbObj = $GLOBALS['TYPO3_DB'];
		
		/* Check for table name to be existing in configuration */
		if (!array_key_exists('table', $this->conf) || $this->conf['table'] == '') {
			if (array_key_exists($rowObjectClassName, $GLOBALS['TCA']) && $GLOBALS['TCA'][$rowObjectClassName] != '') {
				/* Lookup TCA for table configuration of given class name */
				$this->tableName = $rowObjectClassName;
			} elseif ($this->existsTable($rowObjectClassName)) {
				/* Use non-TCA table without configuration in ext_localconf */
				$this->tableName = $rowObjectClassName;
			} else {
				throw new tx_pttools_exceptionConfiguration('No configuration given for ' . $rowObjectClassName, 'No configuration given for ' . $rowObjectClassName);
			}
		} else {
			$this->tableName = $this->conf['table'];
		}
		$this->isReadOnlyAccessor = $isReadOnlyAccessor;
		
	}

	
	
	/**
	 * Inserts a row object into storage
	 * 
	 * @param 	pt_objectstorage_rowObject	$rowObject	Row object to be inserted
	 * @return 	int										UID of inserted record
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function insertRowObject($rowObject) {
		
		return $this->insertRowData($rowObject->exportPropertiesToArray());
		
	}

	
	
	/**
	 * Updates a row object in storage
	 * 
	 * @param 	pt_objectstorage_rowObject	$rowObject	Row object to be updated
	 * @return 	void
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function updateRowObject($rowObject) {
		
		$whereClause = $this->createUidWhereCondition($rowObject);
		$this->updateRowData($whereClause, $rowObject->exportPropertiesToArray());
		
	}
	
	
	
	/**
	 * Deletes a row object in storage
	 * 
	 * @param 	pt_objectstorage_rowObject	$rowObject	Row object to be deleted
	 * @return 	void
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function deleteRowObject($rowObject) {
		
		$whereClause = $this->createUidWhereCondition($rowObject);
		$this->deleteRow($whereClause);
		
	}
	
	
	
	/**
	 * Selects row data by a given row UID
	 * 
	 * @param 	tx_ptobjectstorage_rowObject	$rowObject		Row object to select data for
	 * @return 	mixed
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function selectRowDataForObject($rowObject) {
		
		$whereClause = $this->createUidWhereCondition($rowObject, $rowObject->getUidColNames());
		
		/* prepare query */
        $select  = '*';
        $from 	 = $this->tableName;
        $where   = $whereClause;
        $groupBy = '';
        $orderBy = '';
        $limit   = '';
		
        /* exec query using TYPO3 DB API */
        $res = $this->dbObj->exec_SELECTquery($select, $from, $where, $groupBy, $orderBy, $limit);
        $this->doLogging();
        tx_pttools_assert::isMySQLRessource($res);
        $a_row = $this->dbObj->sql_fetch_assoc($res);
        $this->dbObj->sql_free_result($res);
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

		$from = $this->tableName;
		$res = $this->dbObj->exec_INSERTquery($from, $rowDataArray);
		$this->doLogging();
        tx_pttools_assert::isMySQLRessource($res);
        trace($res);
        #$this->dbObj->sql_free_result($res);
        return $GLOBALS['TYPO3_DB']->sql_insert_id();
		
	}
	
	
	
	/**
	 * Updates a row by a given row uid and an array of data
	 * 
	 * @param 	string	$whereClause	Where clause for update
	 * @param 	array	$rowDataArray	Array of key => value to update row
	 * @return 	void
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function updateRowData($whereClause, $rowDataArray) {
		
        $where = $whereClause;
        $from = $this->tableName;
        $res = $this->dbObj->exec_UPDATEquery($from, $where, $rowDataArray);
		$this->doLogging();
        tx_pttools_assert::isMySQLRessource($res);
        #$this->dbObj->sql_free_result($res);
		
	}
	
	
	
	/**
	 * Deletes a row, identified by $uid
	 * 
	 * @param 	string		$whereClause	Where clause for delete
	 * @return 	void
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-02-19
	 */
	public function deleteRow($whereClause, $uidColumn = 'uid') {
		
		$from = $this->tableName;
		$where = $whereClause;
		$res = $this->dbObj->exec_DELETEquery($from, $where);
		$this->doLogging();
        tx_pttools_assert::isMySQLRessource($res);
        
	}
	
	
	
	/**
	 * Creates a where condition from an array of uidCols and a rowObject
	 * 
	 * @todo    Do some quoting here!
	 * 
	 * @param 	tx_ptobjectstorage_rowObject	$rowObject		Row object to generate where clause for
	 * @return 	string											Where clause for primary keys
	 * @todo 	perhaps caching could improve performance!
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-03-13
	 */
	protected function createUidWhereCondition($rowObject, $rowUids = array()) {
		
		$whereClauseArray = array();
		$uidColNames = $rowObject->getUidColNames();
		
		foreach ($uidColNames as $uidColName) {
			$rowDataArray = $rowObject->exportPropertiesToArray();
			if (array_key_exists($uidColName, $rowDataArray)) {
				// @todo Using "'" with int vals could make troubles?
				$whereClauseArray[] = $uidColName . " =  '$rowDataArray[$uidColName]'";
			} else {
				throw new tx_pttools_exceptionInternal(
					'Trying to get value for uid col ' . $uidColName . ' but got no value!'
				);
			}
		}

		$whereClause = implode(' AND ', $whereClauseArray);
		return $whereClause;
		
	}

	

	/**
	 * Looks up whether table exists in database
	 * 
	 * @param $tableName
	 * @return unknown_type
	 */
	protected function existsTable($tableName) {
		return tx_pttools_div::dbTableExists($tableName, $this->dbObj);
	}
	
	
	
	/**
	 * Helper method for logging current SQL statements etc. 
	 * 
	 * @return  void
	 * @author  Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-02
	 */
	protected function doLogging() {
		trace(str_replace(chr(9), '', $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery));
        if (TYPO3_DLOG) t3lib_div::devLog('Query from pt_objectstorage', 'pt_objectstorage', 0, array('query' => $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery));
	}
	
	
} 



?>