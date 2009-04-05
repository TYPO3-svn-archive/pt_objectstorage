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
 * Class definition file for implementing a row object for database access (active record)
 *
 * $Id:$
 * 
 * @package		TYPO3
 * @subpackage	pt_objectstorage
 * @author  	Michael Knoll <knoll@punkt.de>
 * @since   	2009-03-11
 */ 
 


/**
 * Include required ressources
 */
require_once(t3lib_extMgm::extPath('pt_objectstorage') . 'res/abstract/class.tx_ptobjectstorage_ptRowObject.php');
require_once(t3lib_extMgm::extPath('pt_tools') . 'res/objects/exceptions/class.tx_pttools_exceptionInternal.php');
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/objects/class.tx_ptobjectstorage_genericRowObjectFactory.php';



/**
 * Class for implementing a generic row object
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package Typo3
 * @subpackage pt_objectstorage
 * @since 2009-03-11
 * 
 */
class tx_ptobjectstorage_genericRowObject extends tx_ptobjectstorage_ptRowObject {


	
	/**
	 * Define some constants for configuration type
	 */
	const TCA_CONFIG = 'tca_config';
	const DB_SCHEMA_CONFIG = 'db_schema_config';
	const EXT_LOCALCONF_CONFIG = 'ext_localconf_config';
	const MANUAL_CONFIG = 'manual_config';
	
	
	
	
	/**
	 * Tablename of the corresponding table
	 * 
	 * @var string
	 */
	protected $tableName;
	
	
	
	/**
	 * Array of config parameters
	 * 
	 * @var array
	 */
	protected $configParameters;
	
	
	
	/**
	 * Type of configurations for fields (from constants)
	 * 
	 * @var string
	 */
	protected $configType;
	
	
	
	/**
	 * Array of column names that are used as primary keys
	 * 
	 * @var array
	 */
	protected $uidColNames;
	
	
	
	/**
	 * Constructor for generic row object
	 * 
	 * @param 	string	$tableName			Name of table, row object is assigned to
	 * @param	string	$configType			Type of configuration (use constants for setting!)
	 * @param 	mixed	$rowUids			UID(s) of row to load into row object can be array ('uidColName' => $value) or scalar, than 'uid' is suggested as uid col name
	 * @param 	bool	$throwErrorOnNonExistingUid	If true, throw exception if row uid has no corresponding row in table
	 * @param   array	$configParameters	Further config parameters
	 * @return 	void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	public function __construct(
		$tableName,
		$configType = self::TCA_CONFIG,
		$rowUids = 0,
		$throwErrorOnNonExistingUid = false,
		$configParameters = array()
	) {
		
		tx_pttools_assert::isNotEmptyString($tableName, array('message' => 'Table name must not be empty!'));
		tx_pttools_assert::isNotEmptyString($configType, array('message' => 'Configuration Type must not be empty!'));
		
		$this->tableName = $tableName;
		$this->configParameters = $configParameters;
		$this->configType = $configType;
		#$this->initPrimaryKeys();
				
		parent::__construct($rowUids, $throwErrorOnNonExistingUid);
		
	}

	
	
	/**********************************************************************************************
	 *  Template Methods
	 **********************************************************************************************/
		
	
	
	/**
	 * Overwrite method for initializing row accessor.
	 * 
	 * @return 	void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	protected function initRowAccessor() {
		
		$this->rowAccessor = tx_ptobjectstorage_accessorFactory::getInstanceById($this->tableName);
		
	}
	
	
	
	/**
	 * Initialization of primary key columns
	 * 
	 * @return void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
//	protected function initPrimaryKeys() {
//		/* check, whether non-standard primary key exists */
//		if (array_key_exists('primaryKeyColumns', $this->configParameters)) {
//			if (is_array($this->configParameters['primaryKeyColumns'])) {
//				/* got a list of columns as primary keys */
//				$this->uidColNames = $this->configParameters['primaryKeyColumns'];
//			} else {
//				/* got a single column as primary key */
//				$this->uidColNames = array($this->configParameters['primaryKeyColumns']);
//			}
//		} else {
//			/* set default primary key (uid) */
//			$this->uidColNames = array('uid');
//		}
//	}
	
	
	
	/**
	 * Overwrite method for getting col names array
	 * 
	 * @see 	res/abstract/tx_ptobjectstorage_rowObject#getUidColNames()
	 * @return	array	Array of column names
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	public function getUidColNames() {
		/**
		 * Remember: there can be more than 1 primary key columns!
		 */
		return $this->uidColNames;
	}
	
	
	
	/**
	 * Sets array of fields that can't be returned by magic getter
	 * 
	 * Overwrite method to manipulate non-gettable fields
	 * 
	 * @return void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	protected function setNonGettableFields() {
		
		if (is_array($this->configParameters['nonGettableFields'])) {
			$this->nonGettableFields = $this->configParameters['nonGettableFields'];
		} else {
			parent::setNonGettableFields();
		}
		
	}
	
	
	
	/**
	 * Overwrite method to manipulate non-settable fields
	 * 
	 * @return void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	protected function setNonSettableFields() {
		
		if (is_array($this->configParameters['nonSettableFields'])) {
			$this->nonSettableFields = $this->configParameters['nonSettableFields'];
		} else {
			parent::setNonSettableFields();
		}
		
	}
	
	
	
	/**
	 * Overwrite-method to manipulate required fields
	 * 
	 * @return void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	protected function setRequiredFields() {
		
		if (is_array($this->configParameters['requiredFields'])) {
			$this->requiredFields = $this->configParameters['requiredFields'];
		} else {
			parent::setRequiredFields();
		}
		
	}
	
	
	
	/**
	 * Overwrite-method to manipulate available fields
	 * 
	 * @return void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-03-12
	 */
	protected function setAvailableFields() {

		/* Should be refactored soon! */
		// @todo: use strategy class to impelement configuration of fields!
		switch ($this->configType) {
			
			
			case self::TCA_CONFIG :
				/* Take config from TCA */
				if (is_array($GLOBALS['TCA'][$this->tableName])) {
					$this->availableFieldsArray = array_keys($GLOBALS['TCA'][$this->tableName]['columns']);
				} else {
					throw new tx_pttools_exceptionConfiguration('No configuration available in TCA for ' . $this->tableName);
				}
				break;
				
				
			case self::DB_SCHEMA_CONFIG :
				/* Take config from DB Schema */
				// @TODO: cache this functionality in factory
				tx_pttools_assert::isNotEmptyString($this->tableName);
				$query = "SHOW COLUMNS FROM " . $this->tableName;
				$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
				tx_pttools_assert::isMySQLRessource($res);
				while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
					$availableFields[] = $row['Field'];
				}
				$this->availableFieldsArray = $availableFields;
				break;
				
				
			case self::EXT_LOCALCONF_CONFIG :
				/* Take config from EXT_LOCALCONF.php */
				if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_objectstorage']['classes'][$this->tableName]['availableFields'])) {
					$this->availableFieldsArray = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_objectstorage']['classes'][$this->tableName]['availableFields'];
				} else {
					throw new tx_pttools_exceptionConfiguration('No configuration found for table ' . $this->tableName . 
						' set $TYPO3_CONF_VARS' . "['EXTCONF']['pt_object_storage']['classes']['" . $this->tableName . "']['availableFields']"
					);
				}
				break;
				
				
			case self::MANUAL_CONFIG :
				/* Read available fields from given config parameters */
				if (is_array($this->configParameters['availableFields'])) {
					$this->availableFieldsArray = $this->configParameters['availableFields'];
				} else {
					throw new tx_pttools_exceptionInternal('No available fields given in config parameters ($configParameters[\'availableFields\']');
				}
				break;
				
				
			default :
				// @todo: Is it better to call parent setAvailableFields()???
				throw new tx_pttools_exceptionInternal('Unknown configuration method for field configuration');
				
				
		}
		
	} 
	
	
	
	/** 
	 * Returns a factory that creates row objects
	 * 
	 * @return	 void
	 * @author 	Michael Knoll <knoll@punkt.de>
	 * @since 	2009-04-05
	 */
	public static function getRowObjectFactory() {
		return tx_ptobjectstorage_genericRowObjectFactory::getInstance();
	}
	
	
	
}
 
?>