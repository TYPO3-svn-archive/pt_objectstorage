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
 * Class definition file SQL query 
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @since 2009-04-03
 *
 */



/**
 * Inclusion of external resources
 */
require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_debug.php'; // debugging class with trace() function
require_once t3lib_extMgm::extPath('pt_tools').'res/objects/class.tx_pttools_exception.php'; // general exception class



/**
 * Query class for creating db queries
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @since 2009-04-03
 */
class tx_ptobjectstorage_query {
	
	
	
	/**
	 * FROM clause
	 * 
	 * @var string
	 */
	protected $fromClause;
	
	
	
	/**
	 * SELECT clause
	 * 
	 * @var string
	 */
	protected $selectClause;
	
	
	
	/**
	 * WHERE clause
	 * 
	 * @var string
	 */
	protected $whereClause;
	
	
	
	/**
	 * ORDER BY clause
	 * 
	 * @var string
	 */
	protected $orderByClause;
	
	
	
	/**
	 * GROUP BY clause
	 * 
	 * @var string
	 */
	protected $groupByClause;
	
	
	
	/**
	 * LIMIT for selection
	 * 
	 * @var int
	 */
	protected $limitClause;
	
	
	
	/**
	 * Constructor for criteria object
	 * 
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
	public function construct() {
		
	}
	
	
	
	/**************************************************************
	 * setters for query parts
	 **************************************************************/
	
	
	
	/**
	 * Sets FROM part for query (comma separated string of tables and optional aliases)
	 * 
	 * @param 	string						$fromClause		Comma seperated list of tables and optional aliases
	 * @return 	tx_ptobjectstorage_query					Object returns itself for fluent interfaces
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
	public function from($fromClause) {
		$this->fromClause = $fromClause;
		return $this;
	}
	
	
	
	/**
	 * Sets SELECT part for query (comma separated list of fields to select)
	 * 
	 * @param 	string						$selectClause	Comma seperated list of fields and optional aliases
	 * @return 	tx_ptobjectstorage_query					Object returns itself for fluent interfaces
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
	public function select($selectClause) {
		$this->selectClause = $selectClause;
		return $this;
	}
	
	
	
	/**
	 * Sets WHERE part for query
	 * 
	 * @param 	string						$where		Where clause for query
	 * @return 	tx_ptobjectstorage_query				Object returns itself for fluent interfaces
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
	public function where($whereClause) {
		$this->whereClause = $whereClause;
		return $this;
	}
	
	
	
	/**
	 * Sets GROUP BY part for query (comma separated string of fields)
	 * 
	 * @param 	string						$groupByClause	Comma seperated list of fields
	 * @return 	tx_ptobjectstorage_query					Object returns itself for fluent interfaces
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
	public function groupBy($groupByClause) {
		$this->groupByClause = $groupByClause;
		return $this;
	}
	
	
	
	/**
	 * Sets ORDER BY part for query (comma separated string of tables and optional aliases)
	 * 
	 * @param 	string						$orderByClause		Comma seperated list of fields to order records by
	 * @return 	tx_ptobjectstorage_query						Object returns itself for fluent interfaces
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
	public function orderBy($orderByClause) {
		$this->orderByClause = $orderByClause;
		return $this;
	}
	
	
	
	/**
	 * Sets a LIMIT for the number of records to be fetched by query
	 * 
	 * @param 	int							$limitClause	Number of records to be fetched by query
	 * @return 	tx_ptobjectstorage_query					Object returns itself for fluent interfaces
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
	public function limit($limitClause) {
		tx_pttools_assert::isInteger(intval($limitClause));
		$this->limitClause = intval($limitClause);
		return $this;
	}
	
	
	
	/**************************************************************
	 * Query generation
	 **************************************************************/
	
	
	
	/**
	 * Returns SQL query generated from query params
	 * 
	 * @return 	string					SQL query string
	 * @author	Michael Knoll <knoll@punkt.de>
	 * @since	2009-04-03
	 */
    public function getSqlQuery() {
    	$generatedQuery = '';
    	tx_pttools_assert::isNotEmptyString($this->selectClause);
    	$generatedQuery 	.=	'SELECT ' . $this->selectClause . ' ';
    	tx_pttools_assert::isNotEmptyString($this->fromClause);
    	$generatedQuery		.=  'FROM ' . $this->fromClause . ' ';
    	if ($this->whereClause != '') {
    		$generatedQuery .= 'WHERE ' . $this->whereClause;
    	}
    	if ($this->groupByClause != '') {
    		$generatedQuery .= 'GROUP BY ' . $this->groupByClause . ' ';
    	}
    	if ($this->orderByClause != '') {
    		$generatedQuery .= 'ORDER BY ' . $this->orderByClause . ' ';
    	}
    	if ($this->limitClause != '') {
    		tx_pttools_assert::isInteger($this->limitClause);
    		$generatedQuery .= 'LIMIT ' . $this->limitClause . ' ';
    	}
    	return $generatedQuery;
    }
	
	
	
}

 
?>