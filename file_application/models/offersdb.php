<?php

/**
 * DEVELOPER İsmail AKBUDAK
 * Offersdb Model
 *
 * @package     CodeIgniter
 * @category    Model
 * @author      İsmail AKBUDAK
 * @link        http://ismailakbudak.com
 *
 */

class Offersdb extends CI_Model {

	/**
	 * global variable
	 **/
	public $table;

	/**
	 * Constructor
	 **/
	function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = 'events';
	}

	/**
	 *  Update offer method
	 *  @parameter offerid, offer
	 *  RETURN TRUE or FALSE
	 **/
	function UpdateOffer($event_id, $offer) {
		// sunucuda zaman geri olduğu için
		$offer['updated_at'] = date('Y-m-d H:i:s');
		$offer['explain_approval'] = 0;
		$this->db->where('id', $event_id);
		$query = $this->db->update($this->table, $offer);
		if ($query) {
			return ($this->db->affected_rows() >= 0) ? TRUE : FALSE;
		}
		// if there is error returns -1
		else{

			return false;
		}
	}

	/****
	|
	|  Delete offer information with id
	|  @parameter offerid
	|  @RETURN TRUE or FALSE
	|
	 ****/
	function deleteOffer($event_id) {

		$this->db->trans_begin();// because of so many action we need to check all result
		//$query1 =  $this->db->delete('way_points', array('event_id' => $event_id));
		//$query2 =  $this->db->delete('rutin_trip', array('event_id' => $event_id));
		//$query4 =  $this->db->delete('rutin_trip_dates', array('event_id' => $event_id));
		//$query5 =  $this->db->delete('event_paths', array('event_id' => $event_id));
		$query3 = $this->db->delete('events', array('id' => $event_id));
		if ($query3) {// && $query2 && $query1 && $query4 && $query5 ){
			if ($this->db->affected_rows() > 0) {
				$result = TRUE;
			} else {

				$result = FALSE;
			}
		} else {
			$result = FALSE;
		}
		if ($this->db->trans_status() == FALSE || $result == FALSE) {
			$this->db->trans_rollback();// there is some error rollback
			return FALSE;
		} else {
			$this->db->trans_commit();// everything is ok commit actions.
			return TRUE;
		}
	}

	/**
	 *  Get offer information with id
	 *  @parameter offerid
	 *  RETURN row or FALSE
	 **/
	function Get($event_id) {
		$query = $this->db->where('id =', $event_id)
		              ->where('is_active', 1)
		              ->get($this->table);
		if ($query) {
			return $query->row_array();
		} else {

			return FALSE;
		}
	}

	/**
	 *  Get offer information with id
	 *  @parameter offerid
	 *  RETURN row or FALSE
	 **/
	function GetWhere($where) {
		$query = $this->db->where($where)
		              ->where('is_active', 1)
		              ->get($this->table);
		if ($query) {
			return $query->row_array();
		} else {

			return FALSE;
		}
	}

	/**
	 *  Get offer information with id
	 *  @parameter offerid
	 *  RETURN row or FALSE
	 **/
	function GetOffer($event_id) {
		$query = $this->db->where('id =', $event_id)
		              ->get($this->table);
		if ($query) {
			return $query->row_array();
		} else {

			return FALSE;
		}
	}

	/**
	 *  Save offer method
	 *  @parameter offer, waypoints_prices, waypoints_price_color, waypoints_distance, waypoints_distance_time, departure_days, return_days
	 *  RETURN TRUE or FALSE
	 **/
	function saveOffer($event, $event_paths) {

		$date = date('Y-m-d');// Bugünün tarihi
		$user_id = $event['user_id'];// Teklifi yapan kullanıcının id si

		// sunucuda zaman geri olduğu için
		$event['created_at'] = date('Y-m-d H:i:s');

		// Begin to add data
		$this->db->trans_begin();// because of so many action we need to check all result
		$query = $this->db->insert('events', $event);// save offer
		$result = TRUE;
		$event_id = -1;// set offerid begining value
		if ($query) {
			if ($this->db->affected_rows() > 0) {
				$event_id = $this->db->insert_id();// get inserted id
				if ($event_id > 0) {

					// save event_paths
					if ($result && count($event_paths) > 0) {// way points is null or not
						foreach ($event_paths as &$value) {
							$value['event_id'] = $event_id;
						}

						$query = $this->db->insert_batch('event_paths', $event_paths);
						$query = $this->db->insert_batch('created_events', $event_paths);
						if ($query) {
							if ($this->db->affected_rows() > 0) {
								$result = TRUE;
							} else {
								$result = FALSE;
							}
						} else {
							$result = FALSE;
						}
					}
				} else {
					$result = FALSE;
				}
			} else {
				$result = FALSE;
			}
		} else {
			$result = FALSE;
		}

		if ($this->db->trans_status() == FALSE || $result == FALSE) {
			$this->db->trans_rollback();// there is some error rollback
			return FALSE;
		} else {
			$this->db->trans_commit();// everything is ok commit actions.
			return $event_id;
		}
	}

	/**
	 *  Update offer method
	 *  @parameter offer, waypoints_prices, waypoints_price_color, waypoints_distance, waypoints_distance_time, departure_days, return_days
	 *  RETURN TRUE or FALSE
	 **/
	function updateOfferAll($event_id, $event, $event_paths) {

		$date = date('Y-m-d');// Bugünün tarihi
		$user_id = $event['user_id'];// Teklifi yapan kullanıcının id si
		// sunucuda zaman geri olduğu için
		$event['updated_at'] = date('Y-m-d H:i:s');

		// Begin to add data
		$this->db->trans_begin();

		$query = $this->db->where('id', $event_id)
		              ->update($this->table, $event);

		$query2 = $this->db->delete('event_paths', array('event_id' => $event_id));

		$result = TRUE;
		if ($query && $query2) {
			if ($this->db->affected_rows() >= 0) {
				if ($event_id > 0) {
					// save event_paths
					if ($result && count($event_paths) > 0) {// way points is null or not

						$query = $this->db->insert_batch('event_paths', $event_paths);
						$query = $this->db->insert_batch('created_events', $event_paths);
						if ($query) {
							if ($this->db->affected_rows() > 0) {
								$result = TRUE;

							} else {
								$result = FALSE;
							}
						} else {
							$result = FALSE;
						}
					}
				} else {
					$result = FALSE;
				}
			} else {
				$result = FALSE;
			}
		} else {
			$result = FALSE;
		}

		if ($this->db->trans_status() == FALSE || $result == FALSE) {
			$this->db->trans_rollback();// there is some error rollback
			return FALSE;
		} else {
			$this->db->trans_commit();// everything is ok commit actions.
			return $event_id;
		}
	}

	/**
	 *  Get user offers
	 *  @parameter user id
	 *  RETURN rows or FALSE
	 **/
	function GetUserOffer($user_id) {

		$date = date('Y-m-d H:i:s');// current date
		//$where = "CONCAT(`name`,' ',`surname`) LIKE '$name%' AND id != $user_id";

		$where = "user_id ='$user_id' AND ( CONCAT(departure_date,' ',departure_time) >='{$date}' OR CONCAT(return_date,' ', return_time)  >='{$date}')
                                         AND is_active = 1";
		$this->db->where($where)
		     ->order_by("departure_date", "asc")
		     ->distinct();

		$query = $this->db->get($this->table);
		if ($query) {
			return $query->result_array();
		} else {

			return FALSE;
		}
	}

	/**
	 *  Get user offers count as count
	 *  @parameter user id
	 *  RETURN row or FALSE
	 **/
	function GetUserOfferCount($user_id) {
		$query = $this->db->select('user_id, COUNT(id) AS offers_count  ')
		              ->where('user_id =', $user_id)
		              ->group_by('user_id')
		              ->get($this->table);
		if ($query) {
			$result = $query->row_array();
			if ($result) {
				return $result;
			} else {
				$result['offers_count'] = 0;
			}
			return $result;
		} else {

			return FALSE;
		}
	}

	/***
	|
	|  Get user offers that is passed
	|  @parameter user id
	|  RETURN rows or FALSE
	|
	 ***/
	function GetUserOfferOutofDate($user_id) {

		$date = date('Y-m-d H:i:s');// current date
		$where = "user_id ='$user_id' AND CONCAT(departure_date,' ',departure_time)  <'{$date}' AND CONCAT(return_date,' ', return_time) <'{$date}'
                                         AND is_active = 1 ";
		$this->db->where($where)
		     ->order_by("departure_date", "asc");

		$query = $this->db->get($this->table);
		if ($query) {
			return $query->result_array();
		} else {

			return FALSE;
		}
	}

	/***
	 *
	 * Search offers
	 *
	 * @param $origin is departure point
	 * @param $destination  is arrivial point
	 * @param $LIMIT  is how many rows display
	 * @param $OFFSET is row start point
	 * @return rows or FALSE
	 *
	 **/
	function search($origin, $destination, $lat, $lng, $dLat, $dLng, $range, $LIMIT, $OFFSET) {

		$date = date('Y-m-d H:i:s');// current date
		// no hangi gruptan geldiğini
		$range = explode("-", $range);
		if (count($range) == 2) {
			$range = $range[0] . "." . $range[1];
		} else {
			$range = 0.2;
		}

		$min_lat = $lat - $range;
		$max_lat = $lat + $range;
		$min_lng = $lng - $range;
		$max_lng = $lng + $range;
		if ($dLat != -1 && $dLng != -1) {
			$min_dLat = $dLat - $range;
			$max_dLat = $dLat + $range;
			$min_dLng = $dLng - $range;
			$max_dLng = $dLng + $range;
			$twoway = TRUE;
		} else {
			$min_dLat = "true";
			$max_dLat = "true";
			$min_dLng = "true";
			$max_dLng = "true";
			$twoway = FALSE;
		}

		// düz
		$second = $twoway ? "AND ( WO.to_lat >= $min_dLat  AND  WO.to_lat <= $max_dLat AND  WO.to_lng >= $min_dLng  AND  WO.to_lng <= $max_dLng )" : "";
		$one = "( WO.o_from LIKE '%$origin%' AND  WO.d_to LIKE '%$destination%' )  OR
                    (  ( WO.from_lat >= $min_lat  AND  WO.from_lat <= $max_lat AND WO.from_lng >= $min_lng  AND  WO.from_lng <= $max_lng) $second
                     ) ";

		// tersleri için
		$secondReverse = $twoway ? "AND ( WO.from_lat >= $min_dLat  AND  WO.from_lat <= $max_dLat AND WO.from_lng >= $min_dLng  AND  WO.from_lng <= $max_dLng )" : "";
		$oneReverse = "( WO.o_from LIKE '%$destination%' AND  WO.d_to LIKE '%$origin%' )  OR
                            (  ( WO.to_lat >= $min_lat  AND  WO.to_lat <= $max_lat AND  WO.to_lng >= $min_lng  AND  WO.to_lng <= $max_lng) $secondReverse
                             ) ";
		$where = "( $one OR $oneReverse ) AND
                   R.is_active = 1  AND
                   CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";
		$query = $this->db->select('R.*, U.*, L.*, (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                    (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->where($where)
		->order_by("R.departure_date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();

		if ($query) {
			$result = $query->result_array();// tek seferlik gidiş seyahatleri
			return $result;// return search results
		} else {

			return FALSE;
		}
	}

	/***
	 *
	 * Search total count of offers
	 *
	 * @param $origin is departure point
	 * @param $destination  is arrivial point
	 * @param $LIMIT  is how many rows display
	 * @param $OFFSET is row start point
	 * @return row or FALSE
	 *
	 **/
	function searchCount($origin, $destination, $lat, $lng, $dLat, $dLng, $range) {

		$date = date('Y-m-d H:i:s');// current date
		// no hangi gruptan geldiğini
		$range = explode("-", $range);
		if (count($range) == 2) {
			$range = $range[0] . "." . $range[1];
		} else {
			$range = 0.2;
		}

		$min_lat = $lat - $range;
		$max_lat = $lat + $range;
		$min_lng = $lng - $range;
		$max_lng = $lng + $range;
		if ($dLat != -1 && $dLng != -1) {
			$min_dLat = $dLat - $range;
			$max_dLat = $dLat + $range;
			$min_dLng = $dLng - $range;
			$max_dLng = $dLng + $range;
			$twoway = TRUE;
		} else {
			$min_dLat = "true";
			$max_dLat = "true";
			$min_dLng = "true";
			$max_dLng = "true";
			$twoway = FALSE;
		}

		// düz
		$second = $twoway ? "AND ( WO.to_lat >= $min_dLat  AND  WO.to_lat <= $max_dLat AND  WO.to_lng >= $min_dLng  AND  WO.to_lng <= $max_dLng )" : "";
		$one = "( WO.o_from LIKE '%$origin%' AND  WO.d_to LIKE '%$destination%' )  OR
                    (  ( WO.from_lat >= $min_lat  AND  WO.from_lat <= $max_lat AND WO.from_lng >= $min_lng  AND  WO.from_lng <= $max_lng) $second
                     ) ";

		// tersleri için
		$secondReverse = $twoway ? "AND ( WO.from_lat >= $min_dLat  AND  WO.from_lat <= $max_dLat AND WO.from_lng >= $min_dLng  AND  WO.from_lng <= $max_dLng )" : "";
		$oneReverse = "( WO.o_from LIKE '%$destination%' AND  WO.d_to LIKE '%$origin%' )  OR
                            (  ( WO.to_lat >= $min_lat  AND  WO.to_lat <= $max_lat AND  WO.to_lng >= $min_lng  AND  WO.to_lng <= $max_lng) $secondReverse
                             ) ";
		$where = "( $one OR $oneReverse ) AND
                   R.is_active = 1  AND
                   CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";
		$query = $this->db->select('R.*, U.*, L.*, (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                    (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->where($where)
		->order_by("R.departure_date", "asc")
		->get();

		if ($query) {
			$result = $query->result_array();// tek seferlik gidiş seyahatleri

			return count($result);// return search results total count
		} else {

			return FALSE;
		}
	}

	/***
	 *
	 * Offers detailSearch method
	 *
	 * @param $id is event_id or date_id
	 * @param $tip  is  id types event_id or date_id
	 * @param $no  is  which sql query
	 * @return rows or FALSE
	 *
	 **/
	function GetOfferForSearchResult($id) {

		$query = $this->db->select('R.id AS id,
		                            R.id AS event_id,
		                            R.is_way ,
		                            R.trip_type ,
                                    R.origin  ,
                                    R.destination  ,
                                    R.user_id,
                                    R.created_at,
                                    R.way_points,
                                    R.trip_type,
                                    R.round_trip,
                                    R.departure_date,
                                    R.departure_time,
                                    R.return_date,
                                    R.return_time,
                                    R.explain_departure,
                                    ( SELECT COUNT(id) FROM look_at WHERE event_id = R.id ) AS look')
		->from('events AS R')
		->where('R.is_active', 1)
		->where('R.id', $id)
		->get();

		if ($query) {
			$offer = $query->row_array();
			if (is_array($offer) && count($offer) > 0) {
				$query2 = $this->db->select('*,
                                                   (SELECT COUNT(id) FROM events WHERE user_id = ' . $offer["user_id"] . ' ) AS offer_count,
                                                   (SELECT AVG(rate) FROM ratings WHERE received_userid = ' . $offer["user_id"] . ' ) AS avg,
                                                   (SELECT COUNT(id) FROM ratings WHERE received_userid = ' . $offer["user_id"] . ' ) AS total,
                                                   users.id as id')
				->from('users')
				->join('user_level', 'users.level_id = user_level.level_id')
				->where('users.id', $offer['user_id'])
				->get();
				$query3 = $this->db->select("*, ratings.created_at")
				               ->from("ratings")
				               ->join('users', 'users.id = ratings.given_userid')
				               ->where('received_userid', $offer['user_id'])
				               ->limit(5)
				               ->get();

				if ($query2 && $query3) {
					$users = $query2->row_array();
					$ratings = $query3->result_array();
					if (is_array($users) && is_array($ratings)) {
						$users['ratings'] = $ratings;
						$offer['user'] = $users;
						return $offer;
					} else {
						return FALSE;
					}
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/***
	 *
	 * Offers get method for last, today and best offer
	 *
	 * @return array or FALSE
	 *
	 **/
	function GetOfersForMain() {
		$LIMIT = 4;
		$OFFSET = 0;
		//   U.foto_exist = 1 AND

		$date = date("Y-m-d H:i:s");
		$where = "R.is_active = 1  AND
                   CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";

		// Son eklenen teklifleri al
		$query1 = $this->db->select('R.id AS event_id,
                                        R.destination,
                                        R.origin,
                                        R.departure_date,
                                        U.name,
                                        U.surname,
                                        U.sex,
                                        U.foto,
                                        U.face_check,
                                        U.birthyear')
		->from('events AS R')
		->join('users AS U', 'U.id = R.user_id')
		->where($where)
		->order_by("R.id", "desc")
		->limit($LIMIT, $OFFSET)
		->get();

		// Yakın tarihte olan teklifleri al
		$query2 = $this->db->select('R.id AS event_id,
                                         R.destination,
                                         R.origin,
                                         R.departure_date,
                                         U.name,
                                         U.surname,
                                         U.sex,
                                         U.foto,
                                         U.face_check,
                                         U.birthyear')
		->from('events AS R')
		->join('users AS U', 'U.id = R.user_id')
		->where($where)
		->order_by("R.departure_date", "asc")
		->limit($LIMIT, $OFFSET)
		->get(); 
		if ($query1 && $query2  ) { 
			return array('last' => $query1->result_array(),
				'today' => $query2->result_array() );
		} else {
			return FALSE;
		}
	}

	/***
	 *
	 * Offers get method for last, today and best offer
	 *
	 * @return array or FALSE
	 *
	 **/
	function GetOfersForMainCount() { 
        
        $date = date("Y-m-d H:i:s",strtotime("-1 month"));
         
		$where = "R.is_active = 1  AND
                  CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";

        // Tarihe gore gruplanmis teklifler
		$query3 = $this->db->select('COUNT(R.id) AS number,
                                     R.departure_date,
                                   ')
		->from('events AS R') 
		->where($where)
		->group_by("R.departure_date")
		->get();

		if (  $query3) {
			return $query3->result_array();
		} else {
			return FALSE;
		}
	}

}
// END of the Offersdb Class

/**
 *
 * End of the file offersdb.php
 *
 **/
