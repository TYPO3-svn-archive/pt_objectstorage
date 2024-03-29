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
 * Interface definition file for iStorable interface
 *
 * $Id: class.tx_ptobjectstorage_iStorable.php,v 1.3 2009/03/16 10:52:01 ry21 Exp $
 *
 * @author  Michael Knoll <knoll@punkt.de>
 * @since   2009-02-19
 */ 
 
 

/**
 * Interface for storable objects
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-02-19
 */
interface tx_ptobjectstorage_iStorable {

	
	
	/**
	 * Exports current field values to array
	 * 
	 * @return array	Array of key => value with current field values
	 */
	public function exportPropertiesToArray();
	
	
	
	/**
	 * Returns UID of object
	 * 
	 * @return array		Array of uids
	 */
	public function getUids();
	
	
	
	/**
	 * Returns UID col name of row object
	 * 
	 * @return string
	 */
	public function getUidColNames();

	
	
}
 
 ?>