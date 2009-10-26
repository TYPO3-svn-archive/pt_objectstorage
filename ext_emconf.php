<?php

########################################################################
# Extension Manager/Repository config file for ext: "pt_objectstorage"
#
# Auto generated 26-10-2009 12:17
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'punkt.de Object Storage',
	'description' => 'Lightwight Object Storage Framework for persisting objects.',
	'category' => 'misc',
	'author' => 'Michael Knoll',
	'author_email' => 'knoll@punkt.de',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => 'punkt.de GmbH',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.0.2dev',
	'_md5_values_when_last_written' => 'a:36:{s:12:"ext_icon.gif";s:4:"4546";s:17:"ext_localconf.php";s:4:"f013";s:14:"ext_tables.php";s:4:"f272";s:59:"tests/class.tx_ptobjectstorage_accessorFactory_testcase.php";s:4:"2b58";s:60:"tests/class.tx_ptobjectstorage_feUsersRowObject_testcase.php";s:4:"6b7f";s:60:"tests/class.tx_ptobjectstorage_genericRowObject_testcase.php";s:4:"24d3";s:55:"tests/class.tx_ptobjectstorage_ptRowObject_testcase.php";s:4:"c1af";s:49:"tests/class.tx_ptobjectstorage_query_testcase.php";s:4:"0398";s:54:"tests/class.tx_ptobjectstorage_repository_testcase.php";s:4:"57fe";s:63:"tests/class.tx_ptobjectstorage_rowObjectCollection_testcase.php";s:4:"8fe2";s:53:"tests/class.tx_ptobjectstorage_rowObject_testcase.php";s:4:"9ddd";s:57:"tests/class.tx_ptobjectstorage_t3rowAccessor_testcase.php";s:4:"866e";s:38:"tests/mocks/class.static_countries.php";s:4:"92c4";s:14:"doc/DevDoc.txt";s:4:"405b";s:12:"doc/Doxyfile";s:4:"acd5";s:14:"doc/manual.sxw";s:4:"35b2";s:24:"doc/pt_objectStorage.png";s:4:"cc11";s:20:"static/constants.txt";s:4:"d41d";s:16:"static/setup.txt";s:4:"d41d";s:59:"res/abstract/class.tx_objectstorage_singletoncollection.php";s:4:"ebf9";s:51:"res/abstract/class.tx_ptobjectstorage_iStorable.php";s:4:"8342";s:53:"res/abstract/class.tx_ptobjectstorage_ptRowObject.php";s:4:"32d2";s:53:"res/abstract/class.tx_ptobjectstorage_rowAccessor.php";s:4:"a7f7";s:51:"res/abstract/class.tx_ptobjectstorage_rowObject.php";s:4:"d2c4";s:56:"res/objects/class.tx_ptobjectstorage_accessorFactory.php";s:4:"f271";s:57:"res/objects/class.tx_ptobjectstorage_genericRowObject.php";s:4:"cfce";s:64:"res/objects/class.tx_ptobjectstorage_genericRowObjectFactory.php";s:4:"8acd";s:54:"res/objects/class.tx_ptobjectstorage_mysqlAccessor.php";s:4:"951a";s:63:"res/objects/class.tx_ptobjectstorage_mysqlDatabaseConnector.php";s:4:"5832";s:59:"res/objects/class.tx_ptobjectstorage_ptRowObjectFactory.php";s:4:"e5f2";s:46:"res/objects/class.tx_ptobjectstorage_query.php";s:4:"1adc";s:51:"res/objects/class.tx_ptobjectstorage_repository.php";s:4:"59c9";s:60:"res/objects/class.tx_ptobjectstorage_rowObjectCollection.php";s:4:"d556";s:57:"res/objects/class.tx_ptobjectstorage_rowObjectFactory.php";s:4:"41fd";s:54:"res/objects/class.tx_ptobjectstorage_t3rowAccessor.php";s:4:"ead0";s:66:"res/objects/examples/class.tx_ptobjectstorage_feUsersRowObject.php";s:4:"9e21";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.1.0-0.0.0',
			'typo3' => '4.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
);

?>