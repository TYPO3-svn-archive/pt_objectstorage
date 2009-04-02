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
 * file_description
 *
 * $Id: class.tx_objectstorage_singletoncollection.php,v 1.1 2009/03/09 10:13:03 ry21 Exp $
 *
 * @author  Michael Knoll <knoll@punkt.de>
 * @since   since
 */ 
 


/**
 *
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-02-19
 */
interface tx_ptobjectstorage_iSingletonCollection {

	
	
	/**
	 * Returns an instance of an object for a given Id. Each class
	 * associated to a key is only instanciated once.
	 * 
	 * @param 	string	$instanceId	
	 * @return 	object					Instance of required object
 	 * @author 	Michael Knoll <knoll@punkt.de>
 	 * @since	2009-02-19 
	 */
	public function getInstanceById($instanceId);
	
	

}
 

 
?>