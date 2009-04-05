<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
} 

/* Set some values for testcases */
$TYPO3_CONF_VARS['EXTCONF']['pt_objectstorage']['classes']['static_countries']= array('availableFields' => 
	array('uid',
		'pid',
		'cn_iso_2',
		'cn_iso_3',
		'cn_iso_nr',
		'cn_parent_tr_iso_nr',
		'cn_official_name_local',
		'cn_official_name_en',
		'cn_capital',
		'cn_tldomain',
		'cn_currency_iso_3',
		'cn_currency_iso_nr',
		'cn_phone',
		'cn_eu_member',
		'cn_address_format',
		'cn_zone_flag',
		'cn_short_local',
		'cn_short_en',
		'cn_uno_member',
		'cn_short_de'
    )
);

$TYPO3_CONF_VARS['EXTCONF']['pt_objectstorage']['classes']['tx_ptobjectstorage_feUsersRowObject']
	= array(
		'table' => 'fe_users'
);


?>