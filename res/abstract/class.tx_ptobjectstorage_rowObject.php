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
 * Generic abstract row object for database access 
 *
 * $Id: class.tx_ptobjectstorage_rowObject.php,v 1.5 2009/03/16 16:10:27 ry21 Exp $
 * 
 * @package		TYPO3
 * @subpackage	tx_pttools
 * @author  	Michael Knoll <knoll@punkt.de>
 * @since   	2009-02-18
 */ 
 


/**
 * Include required ressources
 */
require_once t3lib_extMgm::extPath('pt_tools') . 'res/abstract/class.tx_pttools_iSettableByArray.php';
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/abstract/class.tx_ptobjectstorage_iStorable.php';
require_once t3lib_extMgm::extPath('pt_tools') . 'res/objects/class.tx_pttools_exception.php';
 


/**
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package Typo3
 * @subpackage pt_tools
 * @since 2009-02-18
 * 
 * @todo validate object before saving (no saving here, so where can I validate?)
 */
abstract class tx_ptobjectstorage_rowObject implements IteratorAggregate, Countable, tx_pttools_iSettableByArray, tx_ptobjectstorage_iStorable, ArrayAccess {

	
	
	/**
	 * Array of key=>value that reflects the fields and their values in the corresponding
	 * database table. Key of array is fieldname in database.
	 * 
	 * @var array
	 */
	protected $fieldValueArray;
	
	
	
	/**
	 * Array of field names that reflects the fields in the according database.
	 * If array is empty, all fields of the corresponding table are available in object.
	 * 
	 * @var array
	 */
	protected $availableFieldsArray;
	
	
	
	/**
	 * Array of fields that is required for the object to be saved
	 * 
	 * @var array
	 */
	protected $requiredFields;
	
	
	
	/**
	 * Array of fields that are not settable by magic setter
	 * 
	 * @var array
	 */
	protected $nonSettableFields;
	
	
	
	/**
	 * Array of field names that are not gettable by magic getter
	 * 
	 * @var array
	 */
	protected $nonGettableFields;

	
	
	/**
	 * Array of uid cols
	 * @var array
	 */
	protected $uidColNames;
	
	
	
	/***************************************************************************
     * Methods implementing the "ArrayAccess" interface
     **************************************************************************/
	
	
	
	/**
	 * Constructor for rowObject
	 * 
	 * @todo think about the setting of row uids
	 * 
	 * @param 		mixed		$rowUids			array with (rowUidColumn => rowUidValue) or scalar rowUid value
	 * @return 		void
	 * @author  	Michael Knoll <knoll@punkt.de>
 	 * @since   	2009-02-18
	 */
	public function __construct($rowUids = 0) {
		
		/* Initialize Values */
		$this->fieldValueArray = array();
		
		/* Initialize UID columns depending on given rowUids */
		if (is_array($rowUids) && sizeof($rowUids) > 0) {
			tx_pttools_assert::isAssociativeArray($rowUids, array('message' => '$rowUids must be associative array!'));
			/* Array of UID columns possibly with uids to select row from is given */
			$this->uidColNames = array_keys($rowUids);
			foreach ($rowUids as $rowUidKey => $rowUidValue) {
				$this->fieldValueArray[$rowUidKey] = $rowUidValue;
			}
		} elseif ($rowUids != '' && $rowUids > 0) {
			/* Fallback: scalar is given */
			$this->fieldValueArray['uid'] = $rowUids;
			$this->uidColNames[] = 'uid';
		} else {
			/* Fallback: nothing is given */
			$this->uidColNames[] = 'uid';
		}
		
		/* Set field settings */
		$this->setAvailableFields();
		$this->setNonGettableFields();
		$this->setNonSettableFields();
		$this->setRequiredFields();
		
	}
	
	
	
    /***************************************************************************
     *  Methods implementing the "IteratorAggregate" interface
     **************************************************************************/

	
	
    /**
     * Defined by IteratorAggregate interface: returns an iterator for the object
     *
     * @param   void
     * @return  ArrayIterator     object of type ArrayIterator: Iterator for items within this collection
     * @author  Michael Knoll <knoll@punkt.de>
     * @since   2009-03-14
     */
    public function getIterator() {

        $itemIterator = new ArrayIterator($this->fieldValueArray);
        #trace($itemIterator, 0, '$itemIterator');

        return $itemIterator;

    }
	
    
    
    /***************************************************************************
     * Methods implementing the "Countable" interface
     **************************************************************************/

    
    
    /**
     * Defined by Countable interface: Returns the number of items
     *
     * @param   void
     * @return  integer     number of items in the items array
     * @author  Michael Knoll <knoll@punkt.de>
     * @since   2009-03-14
     */
    public function count() {

        return count($this->fieldValueArray);

    }
    
    
	
    /***************************************************************************
     * Methods implementing the "ArrayAccess" interface
     **************************************************************************/
    
	
	
    /**
     * Returns a bool flag whether the given key exists in the internal fieldValueArray
     *
     * @param   string      key/name of the database field to check its existence in the internal fieldValueArray
     * @return  boolean     flag whether the given key exists in the internal fieldValueArray
     * @author  Rainer Kuhn <kuhn@punkt.de>
     * @since   2009-03-12
     */
    public function offsetExists($offset) {
        
        return array_key_exists($offset, $this->fieldValueArray);
        
    }

    
    
    /**
     * Returns a value from the internal fieldValueArray for a given key
     *
     * @param   string      key/name of the database field to return its value
     * @return  mixed       value of the requested key
     * @author  Rainer Kuhn <kuhn@punkt.de>
     * @since   2009-03-12
     */
    public function offsetGet($offset) {
        
        return $this->fieldValueArray[$offset];
        
    }

    
    
    /**
     * Sets a given value into a given key/name of the database field in the internal fieldValueArray
     *
     * @param   mixed       value of the set into the given key/name of the database field
     * @return  boolean     
     * @author  Rainer Kuhn <kuhn@punkt.de>
     * @since   2009-03-12
     */
    public function offsetSet($offset, $value) {
        
        return $this->fieldValueArray[$offset] = $value;
        
    }

    
    
    /**
     * Unsets a given key/name of the database field in the internal fieldValueArray
     *
     * @param   string      key/name of the database field to unset
     * @return  boolean     void
     * @author  Rainer Kuhn <kuhn@punkt.de>
     * @since   2009-03-12
     */
    public function offsetUnset($offset) {
        
        unset($this->fieldValueArray[$offset]);
        
    }
	
		
	
	/* ********************************************************************
	 * Implementation of tx_pttools_iSettableByArray
	 * ********************************************************************/
	
	
	
	/**
	 * Sets properties from an array
	 * 
	 * @see 		res/abstract/tx_pttools_iSettableByArray#setPropertiesFromArray()
	 * @param 		$dataArray		Array of data to be set in object
	 * @return 		void
	 * @author  	Michael Knoll <knoll@punkt.de>
 	 * @since   	2009-02-18
	 */
	public function setPropertiesFromArray(array $dataArray) {
		
		if (is_array($this->availableFieldsArray) && sizeof($this->availableFieldsArray) > 0) {
			
			/* only available fields are set from database */
			foreach ($this->availableFieldsArray as $fieldName) {
				if (array_key_exists($fieldName, $dataArray)) {
					// TODO add hook for value transformation
					$this->fieldValueArray[$fieldName] = $dataArray[$fieldName];
				} else {
					if (in_array($fieldName, $this->requiredFields)) {
						// TODO add hook for missing value case
						throw new tx_pttools_exceptionInternal(
							'Required value is missing!', 
							'Required value for ' . $fieldName . ' is missing!'
						);
					}
				}
			}
			
		} else {
			
			/* all fields are set from database */
			$this->fieldValueArray = $dataArray;
			
		}
		
	}
	
	
	
	/* ********************************************************************
	 * Implementation of tx_ptobjectstorage_iStorable interface
	 * ********************************************************************/
	
	
	
	/**
	 * Returns uid of corresponding row
	 * 
	 * @return array		UID of corresponding row
	 */
	public function getUids(){
		
		$rowUids = array();
		foreach ($this->uidColNames as $uidColumn) {
			$rowUids[$uidColumn] = $this->fieldValueArray[$uidColumn];
		}
		return $rowUids;
		
	}
	
	
	
	/**
	 * Returns current field values as array of key => value
	 * 
	 * @return array	Field values as key => value
	 */
	public function exportPropertiesToArray() {
		
		return $this->fieldValueArray;
		
	}
	
	
	
	/**
	 * Returns names of UID col of row object
	 * 
	 * Overwrite method to make row object work with tables that have another 
	 * column than 'uid' as ID field
	 * 
	 * @return array	Array of UidColNames
	 */
	public function getUidColNames() {
		
		return $this->uidColNames;
		
	}
	
	
	
	/* ********************************************************************
	 * Magic methods
	 * ********************************************************************/
	
	
	
	/**
	 * Magic method for function call
	 * 
	 * use $object->get_<property_name> to access properties from fieldArray
	 * use $object->set_<property_name> to set properties in fieldArray
	 * 
	 * @param $method		Name of the method to be called
	 * @param $arguments	Arguments passed to the function
	 * @return mixed
	 */
	public function __call($method, $arguments)	{
		
		
		
		/* Magic getter */
		if (substr($method, 0, 4) == 'get_') {
			
			$propertyName = substr($method, 4);
			/* Try to call existing getter function */
			if (!in_array($propertyName, $this->nonGettableFields) && in_array($propertyName, $this->availableFieldsArray)) {
				/* Return value from internal array structure */
				return $this->fieldValueArray[$propertyName];
			} else {
				throw new tx_pttools_exceptionInternal(
					'Trying to access non readable attribute!',
					'Trying to access non readable attribute ' . $propertyName
				);
			}
		}
		
		/* Magic setter */
		if (substr($method, 0, 4) == 'set_') {
			$propertyName = substr($method, 4);
			/* Try to call existing setter method */
			if (!in_array($propertyName, $this->nonSettableFields)) {
				/* Try to call validation method */
				if (method_exists($this, 'validate_' . $propertyName)) {
					// validate_ should throw exception if validation fails
					$this->{'validate_' . $propertyName}($arguments[0]);
				}
				if (in_array($propertyName,$this->availableFieldsArray)) {
					$this->fieldValueArray[$propertyName] = $arguments[0];
				} else {
					throw new tx_pttools_exceptionInternal(
						'Trying to set non-existing attribute!',
						'Trying to set non-existing attribute "' . $propertyName . '"'
					);
				}
				
			} else {
				throw new tx_pttools_exceptionInternal(
					'Trying to set non-settable attribute!',
					'Trying to set non-settable attribute ' . $propertyName
				);
			}
			return;
		}
		
		/* No valid method was called */
		throw new tx_pttools_exceptionInternal(
			'Trying to call non-implemented method',
			'Trying to call non-implemented method "' . $method . '"'
		);
		
	}

	
	
	/* ********************************************************************
	 * Protected methods
	 * ********************************************************************/
	
	
	
	/**
	 * Sets array of fields that can't be returned by magic getter
	 * 
	 * Overwrite method to manipulate or set array with non-gettable fields
	 * 
	 * @return void
	 */
	protected function setNonGettableFields() {
		
		$this->nonGettableFields = array();
		
	}
	
	
	
	/**
	 * Sets array of fields that can't be returned by magic setter
	 * 
	 * Overwrite method to manipulate or set array with non-settable fields
	 * 
	 * @return void
	 */
	protected function setNonSettableFields() {
		
		$this->nonSettableFields = array();
		
	}
	
	
	
	/**
	 * Sets array of fields that need to be available in database
	 * 
	 * Overwrite method to manipuate or set array with required fields
	 * 
	 * @return void
	 */
	protected function setRequiredFields() {
		
		$this->requiredFields = array();
		
	}
	
	
	
	/**
	 * Sets the available fields of database table
	 * 
	 * Overwrite method to manipulate or set array with available fields
	 * 
	 * @return void
	 */
	protected function setAvailableFields() {

		$this->availableFieldsArray = array();
		
	} 
	
	
	
}
 
?>