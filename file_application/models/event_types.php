<?php

/**
 * DEVELOPER İsmail AKBUDAK
 * Event_Types Model
 *
 * @package     CodeIgniter
 * @category    Model
 * @author      İsmail AKBUDAK
 * @link        http://ismailakbudak.com
 *
 */

class Event_Types extends CI_Model {

	/**
	 * Constructor
	 **/
	public $table;

	/**
	 * Constructor
	 **/
	function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = 'event_types';
	}

	/**
	 *  Get offer ways_offers
	 *  @parameter offerid
	 *  RETURN rows or FALSE
	 **/
	function Get() {
		$query = $this->db->get('event_types');
		if ($query) {
			$result = $query->result_array();
			return $result;
		} else {
			return FALSE;
		}

	}
}
// END of the Way_Points Class

/**
 *
 * End of the file Event_Types.php
 *
 **/