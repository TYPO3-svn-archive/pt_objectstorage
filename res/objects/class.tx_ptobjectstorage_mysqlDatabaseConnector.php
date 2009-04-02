<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2005-2009 Michael Knoll (knoll@punkt.de), Fabrizio Branca (branca@punkt.de)
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
 * Inclusions of Typo3 ressources
 */
require_once(PATH_t3lib.'class.t3lib_db.php');



/**
 * Inclusion of other ressources
 */
require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_debug.php'; // debugging class with trace() function
require_once t3lib_extMgm::extPath('pt_tools').'res/objects/class.tx_pttools_exception.php'; // general exception class
require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_div.php'; // general helper library class
require_once t3lib_extMgm::extPath('pt_tools').'res/abstract/class.tx_pttools_iSingleton.php'; // interface for Singleton design pattern
require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_assert.php';



/**
 * Extension class of t3lib_db for external MySql database connections
 * 
 * @package TYPO3
 * @subpackage pt_objectstorage
 * @author Michael Knoll <knoll@punkt.de>, Fabrizio Branca <branca@punkt.de>
 *
 */
class tx_ptobjectstorage_mysqlDatabaseConnector extends t3lib_db {
        
	
	
    protected $host = '';           // (string)
    protected $database = '';       // (string)
    protected $user = '';           // (string)
    protected $pass = '';           // (string)
    
    protected $connection = NULL;     // (resource)
    protected $selectDbResult = NULL; // (boolean) 
    
    
    
    /**
     * Constructor
     * 
     * @param $dsn		DSN of MySql database to be connected
     * @return void     
     * @author  Michael Knoll <knoll@punkt.de>
     * @since   2009-02-13
     */
    public function __construct($dsn) {
        $this->store_lastBuiltQuery = true;
        
        $dsnArray = self::parseDSN($dsn);
        
		$this->host     = $dsnArray['hostspec'];
		$this->database = $dsnArray['database'];
		$this->user     = $dsnArray['username']; 
		$this->pass     = $dsnArray['password'];
		
        // allow individual database intialization
        // $TYPO3setDBinit = $GLOBALS['TYPO3_CONF_VARS']['SYS']['setDBinit']; 
        // $GLOBALS['TYPO3_CONF_VARS']['SYS']['setDBinit'] = $extConfArr['dbGSAsetDBinit']; // this will be used now for GSA DB initialization in t3lib_db::sql_pconnect() below
        
        // connect to database server and select database
        tx_pttools_assert::isNotEmptyString($this->host, array('message'=>'No database host found!'));
        tx_pttools_assert::isNotEmptyString($this->database, array('message'=>'No database name found!'));
        tx_pttools_assert::isNotEmptyString($this->user, array('message'=>'No database user found!'));  // note: password my be empty, this is not an error
        
        $this->connection = @$this->sql_pconnect($this->host, $this->user, $this->pass);
        tx_pttools_assert::isMySQLRessource($this->connection, $this, array('message' => 'Could not connect to database server!'));

        $this->selectDbResult = $this->sql_select_db($this->database);
        tx_pttools_assert::isTrue($this->selectDbResult, array('message' => 'Could not select database!', 'sql_error' => $this->sql_error()));
        
        // re-set original TYPO3 database intialization if overwritten for an external GSA database
		// $GLOBALS['TYPO3_CONF_VARS']['SYS']['setDBinit'] = $TYPO3setDBinit; // perform all other connects with original TYPO3 setting
    }
    
    
    
 	/**
 	 * phptype(dbsyntax)://username:password@protocol+hostspec/database?option=8&another=true
 	 * 
 	 * 
     * @see http://euk1.php.net/package/DB/docs/latest/DB/DB.html#methodparseDSN
     * @author Fabrizio Branca <branca@punkt.de>
     */
    public static function parseDSN($dsn){
        $parsed = array(
            'phptype'  => false,
            'dbsyntax' => false,
            'username' => false,
            'password' => false,
            'protocol' => false,
            'hostspec' => false,
            'port'     => false,
            'socket'   => false,
            'database' => false,
        );

        if (is_array($dsn)) {
            $dsn = array_merge($parsed, $dsn);
            if (!$dsn['dbsyntax']) {
                $dsn['dbsyntax'] = $dsn['phptype'];
            }
            return $dsn;
        }

        // Find phptype and dbsyntax
        if (($pos = strpos($dsn, '://')) !== false) {
            $str = substr($dsn, 0, $pos);
            $dsn = substr($dsn, $pos + 3);
        } else {
            $str = $dsn;
            $dsn = null;
        }

        // Get phptype and dbsyntax
        // $str => phptype(dbsyntax)
        $arr = array();
        if (preg_match('|^(.+?)\((.*?)\)$|', $str, $arr)) {
            $parsed['phptype']  = $arr[1];
            $parsed['dbsyntax'] = !$arr[2] ? $arr[1] : $arr[2];
        } else {
            $parsed['phptype']  = $str;
            $parsed['dbsyntax'] = $str;
        }

        if (!count($dsn)) {
            return $parsed;
        }

        // Get (if found): username and password
        // $dsn => username:password@protocol+hostspec/database
        if (($at = strrpos($dsn,'@')) !== false) {
            $str = substr($dsn, 0, $at);
            $dsn = substr($dsn, $at + 1);
            if (($pos = strpos($str, ':')) !== false) {
                $parsed['username'] = rawurldecode(substr($str, 0, $pos));
                $parsed['password'] = rawurldecode(substr($str, $pos + 1));
            } else {
                $parsed['username'] = rawurldecode($str);
            }
        }

        // Find protocol and hostspec
        $match = array();
        if (preg_match('|^([^(]+)\((.*?)\)/?(.*?)$|', $dsn, $match)) {
            // $dsn => proto(proto_opts)/database
            $proto       = $match[1];
            $proto_opts  = $match[2] ? $match[2] : false;
            $dsn         = $match[3];

        } else {
            // $dsn => protocol+hostspec/database (old format)
            if (strpos($dsn, '+') !== false) {
                list($proto, $dsn) = explode('+', $dsn, 2);
            }
            if (strpos($dsn, '/') !== false) {
                list($proto_opts, $dsn) = explode('/', $dsn, 2);
            } else {
                $proto_opts = $dsn;
                $dsn = null;
            }
        }

        // process the different protocol options
        $parsed['protocol'] = (!empty($proto)) ? $proto : 'tcp';
        $proto_opts = rawurldecode($proto_opts);
        if (strpos($proto_opts, ':') !== false) {
            list($proto_opts, $parsed['port']) = explode(':', $proto_opts);
        }
        if ($parsed['protocol'] == 'tcp') {
            $parsed['hostspec'] = $proto_opts;
        } elseif ($parsed['protocol'] == 'unix') {
            $parsed['socket'] = $proto_opts;
        }

        // Get dabase if any
        // $dsn => database
        if ($dsn) {
            if (($pos = strpos($dsn, '?')) === false) {
                // /database
                $parsed['database'] = rawurldecode($dsn);
            } else {
                // /database?param1=value1&param2=value2
                $parsed['database'] = rawurldecode(substr($dsn, 0, $pos));
                $dsn = substr($dsn, $pos + 1);
                if (strpos($dsn, '&') !== false) {
                    $opts = explode('&', $dsn);
                } else { // database?param1=value1
                    $opts = array($dsn);
                }
                foreach ($opts as $opt) {
                    list($key, $value) = explode('=', $opt);
                    if (!isset($parsed[$key])) {
                        // don't allow params overwrite
                        $parsed[$key] = rawurldecode($value);
                    }
                }
            }
        }

        return $parsed;
    }

    
    
}

?>