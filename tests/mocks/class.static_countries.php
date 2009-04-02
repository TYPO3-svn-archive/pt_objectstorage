<?php 



/**
 * Example file for an row object class implementation
 */



require_once(t3lib_extMgm::extPath('pt_objectstorage').'res/abstract/class.tx_ptobjectstorage_ptRowObject.php');



class static_countries extends tx_ptobjectstorage_ptRowObject {

	
	
	/**
	 * Sets the available fields of database table
	 * 
	 * @return void
	 */
	protected function setAvailableFields() {

		$this->availableFieldsArray = array(
			'uid',
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
		);
		
	} 
	
	
	
	/**
	 * Sets array of fields that can't be returned by magic setter
	 * 
	 * @return void
	 */
	protected function setNonSettableFields() {
		
		$this->nonSettableFields = array('uid');
		
	}
	
	
	
}

?>