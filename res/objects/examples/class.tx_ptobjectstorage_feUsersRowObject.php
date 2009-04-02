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
 * Fe Users row object (as an example for tx_ptobjectstorage_ptRowObject)
 *
 * $Id: class.tx_ptobjectstorage_feUsersRowObject.php,v 1.1 2009/03/16 10:52:01 ry21 Exp $
 * 
 * @package		TYPO3
 * @subpackage	tx_pttools
 * @author  	Michael Knoll <knoll@punkt.de>
 * @since   	2009-03-15
 */ 
 


/**
 * Include required ressources
 */
require_once t3lib_extMgm::extPath('pt_objectstorage') . 'res/abstract/class.tx_ptobjectstorage_ptRowObject.php';
 


/**
 * Example class for using tx_ptobjectstorage_ptRowObject
 * 
 * Creates rows for fe_users table for a given fe user's uid
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package Typo3
 * @subpackage pt_tools
 * @since 2009-03-15
 */
class tx_ptobjectstorage_feUsersRowObject extends tx_ptobjectstorage_ptRowObject {

	
	
	/**
	 * Constructor for fe_users row object
	 * 
	 * @param 	int		$feUserUid	UID of fe user
	 * @return 	void
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-03-15
	 */
	public function __construct($feUserUid = 0) {
		
		$this->tableName = 'fe_users';
		parent::__construct(array('uid' => $feUserUid));
		
		
	}
	
	
	
	/**
	 * Template method for setting available fields.
	 * 
	 * Best practice is to copy fields from database table and put them in an array here.
	 * All fields that are setted in this array have to be valid database fields and are
	 * gettable via $rowObject->get_{field_name}() and settable via $rowObject->set_{field_name}($value)
	 * 
	 * @return void
 	 * @author  Michael Knoll <knoll@punkt.de>
 	 * @since   2009-03-15
	 */
	protected function setAvailableFields() {
		
		$this->availableFieldsArray = array(
			'uid',
			'pid',
			'tstamp',
			'username',
			'password',
			'usergroup',
			'disable',
			'starttime',
			'endtime',
			'name',
			'address',
			'telephone',
			'fax',
			'email',
			'crdate',
			'cruser_id',
			'lockToDomain',
			'deleted',
			'uc',
			'title',
			'zip',
			'city',
			'country',
			'www',
			'company',
			'image',
			'TSconfig',
			'fe_cruser_id',
			'lastlogin',
			'is_online'
		);
		
	}
	
	
	
}

?>