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
 * $Id:$
 *
 * @author  Michael Knoll <knoll@punkt.de>
 * @since   2009-02-19
 */ 



/**
 * Inclusion of required ressources
 */
require_once t3lib_extMgm::extPath('pt_tools') . 'res/objects/class.tx_pttools_exception.php';


 
 /**
  * Repository for loading and storing row objects from database
  *
  * @author Michael Knoll <knoll@punkt.de>
  * @package TYPO3
  * @subpackage pt_objectstorage
  * @since 2009-02-19
  */
 class tx_ptobjectstorage_repository implements tx_pttools_iSingleton {
 
 	
 	
 	/**
 	 * @var tx_ptobjectstorage_repository		Instance of repository for singleton implementation
 	 */
 	protected static $instance;
 	
 	
 	
 	/**
 	 * @var unknown_type	Holds a mapping of tableNames to classNames
 	 */
 	protected $tableClassMapping;
 	
 	
 	
 	/**
 	 * @var unknown_type	Holds a mapping of tableNames to classDefinition file paths
 	 */
 	protected $classPathMapping;
 	
 	
 	
 	/****************************************************************************************
 	 * Construction methods
 	 ****************************************************************************************/
 	
 	
 	
 	/**
 	 * Factory method for getting instance of class
 	 * 
 	 * @return unknown_type
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public static function getInstance() {
 		
 		if (is_null(self::$instance)) {
 			self::$instance = new tx_ptobjectstorage_repository;
 		}
 		return self::$instance;
 		
 	}
 	
 	
 	
 	/**
 	 * Constructor for repository (cannot be used public, use getInstance() instead!)
 	 * 
 	 * @return void
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	protected function __construct() {
 		 	$this->initTableClassMapping();
 		 	$this->initClassPathMapping();
 	}
 	
 	
 	
 	/**
 	 * Clone method is not allowed! Use getInstance instead!
 	 * 
 	 * @return void
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function __clone() {
 		
 		throw new tx_pttools_exceptionInternal('Cannot instantiate static class!');
 		
 	}
 	
 	

 	/***
 	 * Initializes local tablename - class mapping
 	 * 
 	 * @return  void
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	protected function initTableClassMapping() {
 		
 		$this->tableClassMapping = array();
 	}
 	
 	
 	
 	
 	/**
 	 * Initializes local class - classfile path mapping
 	 * 
 	 * @return  void
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	protected function initClassPathMapping() {
 		
 		$this->classPathMapping = array();
 		
 	}
 	
 	
 	
 	/****************************************************************************************
 	 * Public methods
 	 ****************************************************************************************/
 	
 	
 	
 	/**
 	 * Register class and classpath for a tablename
 	 * 
 	 * @param 	string	$tableName	Name of table 
 	 * @param	string	$className	Name of class
 	 * @param	string	$classPath	Path to class definition file
 	 * @return 	void
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function registerTableClassPath($tableName, $className, $classPath) {
 		
 		$this->tableClassMapping[$tableName] = $className;
 		$this->classPathMapping[$className] = $classPath;
 		
 	}
 	
 	
 	
 	/**
 	 * Stores a given object into whatever storage
 	 * 
 	 * @param 	tx_ptobjectstorage_rowObject	$object		Object to store in storage
 	 * @return 	mixed
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function saveRowObject($rowObject) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 	
 	/**
 	 * Creates an object from storage identified by class name and row uid
 	 * 
 	 * @param 	string	$rowObjectClassName 	Name of class to be instanciated
 	 * @param 	int		$uid					UID of row object to be returned
 	 * @return 	tx_ptobjectstorage_rowObject	Requested object from storage
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function getRowObjectByClassNameAndUid($rowObjectClassName, $uid) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 	
 	/**
 	 * Creates a row object for a given table name and a given uid
 	 * 
 	 * @param	string	$tableName				Name of table to generate row object for
 	 * @param	int 	$uid					UID of row to create row object for
 	 * @return 	tx_ptobjectstorage_rowObject	row object for given table name and uid
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function getRowObjectByUid($tableName, $uid) {

 		$rowAccessor = tx_ptobjectstorage_accessorFactory::getInstanceById($tableName);
 		$dataArray = $rowAccessor->selectRowData($uid);
 		$rowObjectClassName = $this->getClassNameByTableName($tableName);
 		$params = array();
 		$params['class_name'] = $rowObjectClassName;
 		$params['table_name'] = $tableName;
 		$params['row_data'] = $dataArray;
		$params['uid_cols'] = array('uid' => $uid);
		$rowObjectFactory = call_user_func($rowObjectClassName . '::getRowObjectFactory');
 		$rowObject = $rowObjectFactory->getInstanceByRepositoryParams($params);
 		return $rowObject;
 		
 	}
 	
 	
 	
 	/**
 	 * Returns a object collection of row objects for a given 
 	 * class name and an array of UIDs
 	 * 
 	 * @param 	string	$className				Name of class of objects to be returned
 	 * @param 	array	$uids					Array of UIDs to be returned
 	 * @return 	tx_pttools_objectCollection		Collection of requested row objects
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function getRowObjectCollectionByClassnameAndUids($className, $uids) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 	
 	/**
 	 * Generates an object collection for a given table name and a set of uids
 	 * 
 	 * @param	string						$tableName	Name of table to generate row objects for
 	 * @param	array						$uids		UIDs of records to generate row objects for
 	 * @return  tx_pttools_objectCollection				Collection of requested row objects
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function getRowObjectCollectionByTableNameAndUids($tableName, $uids) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 	
 	/**
 	 * Generates an object collection for a given query object
 	 * 
 	 * @param 	tx_ptobjectstorage_query		$queryObject	Query object that defines requested Data
 	 * @return  tx_pttools_objectCollection						Collection of requested row objects
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function getRowObjectCollectionByQuery($queryObject) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}
 	
 	
 	
 	/**
 	 * Generates an object collection for a given sql query
 	 * 
 	 * @param	string						$sqlString		SQL string that defines requested data
 	 * @return  tx_pttools_objectCollection					Collection of requested row objects
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function getRowObjectCollectionBySql($sqlString) {
 		
 		throw new tx_pttools_exceptionNotYetImplemented();
 		
 	}


 	
 	
 	/**
 	 * Returns class name for a given tablename
 	 * 
 	 * @param	string	$tableName	Name of table to find class name for
 	 * @return	string				Class name for given table name
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	public function getClassNameByTableName($tableName) {
	 	
 		if ($this->getClassNameFromLocalMapping($tableName) != '') {
 			return $this->getClassNameFromLocalMapping($tableName);
 		}
 		else {
 			return 'tx_ptobjectstorage_genericRowObject';
 		}
 		
 	}
 	
 	
 	
 	/****************************************************************************************
 	 * Protected methods
 	 ****************************************************************************************/
 	
 	
 	
 	/**
 	 * Returns class name of row object for a given table name from local mapping
 	 * 
 	 * @param 	string	$tableName		Name of table to find class name for
 	 * @return	string					Name of class for table
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-04-05
 	 */
 	protected function getClassNameFromLocalMapping($tableName) {
 		
 		if (array_key_exists($tableName, $this->tableClassMapping)) 
 			return $this->tableClassMapping($tableName);
 		else
 			return '';
 			
 	}
 	
 	
 
 }
 
 ?>