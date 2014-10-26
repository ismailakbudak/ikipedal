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
		// tip 0 tekseferlik yolculuk event_id
		// tip 1 çok seferli yolculuk  date_id
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
		$second = $twoway ? "AND ( WO.dLat >= $min_dLat  AND  WO.dLat <= $max_dLat AND  WO.dLng >= $min_dLng  AND  WO.dLng <= $max_dLng )" : "";
		$one = "( WO.departure_place LIKE '%$origin%' AND  WO.arrivial_place LIKE '%$destination%' )  OR
                    (  ( WO.lat >= $min_lat  AND  WO.lat <= $max_lat AND WO.lng >= $min_lng  AND  WO.lng <= $max_lng)
$second
                     ) ";

		// tersleri için
		$secondReverse = $twoway ? "AND ( WO.lat >= $min_dLat  AND  WO.lat <= $max_dLat AND WO.lng >= $min_dLng  AND  WO.lng <= $max_dLng )" : "";
		$oneReverse = "( WO.departure_place LIKE '%$destination%' AND  WO.arrivial_place LIKE '%$origin%' )  OR
                            (  ( WO.dLat >= $min_lat  AND  WO.dLat <= $max_lat AND  WO.dLng >= $min_lng  AND  WO.dLng <= $max_lng)
$secondReverse
                             ) ";
		// NO:1 Tek seferlik GİDİŞ için  way pointsin içinde olmayanları seç
		// R -> events
		$where = "( $one )         AND
                   R.trip_type = 0  AND
                   R.is_active = 1  AND
                   R.is_way    = 0  AND
                   CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";
		$query1 = $this->db->select('R.id AS event_id,
                                        0 AS tip,
                                        0 AS is_way,
                                        R.created_at,
                                        WO.id,
                                        WO.departure_place AS origin,
                                        WO.arrivial_place AS destination,
                                        WO.price AS price_per_passenger,
                                        WO.price_class AS price_class,
                                        R.departure_date,
                                        R.departure_time,
                                        R.number_of_seats,
                                        U.name,
                                        U.surname,
                                        U.sex,
                                        U.foto,
                                        U.face_check,
                                        U.birthyear,
                                        U.friends,
                                        L.level,
                                        L.tr_level,
                                        L.en_level,
                                        P.like_chat,
                                        P.like_pet,
                                        P.like_smoke,
                                        P.like_music,
                                        C.make,
                                        C.model,
                                        C.comfort,
                                        (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                        (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                        1 AS no ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($where)
		->order_by("R.departure_date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();

		//echo "Gidiş için <br>";
		//echo $this->db->last_query();

		// NO:2  Tek seferlik DONUS için  way pointsin içinde olmayanları seç
		// R -> events
		$whereTers = "( $oneReverse )   AND
                       R.trip_type = 0   AND
                       R.round_trip = 1  AND
                       R.is_active = 1   AND
                       R.is_way    = 0   AND
                       CONCAT(R.return_date,' ',R.return_time) >='{$date}' ";
		$query1Ters = $this->db->select('R.id AS event_id,
                                             0 AS tip,
                                             0 AS is_way,
                                             R.created_at,
                                             WO.id,
                                             WO.departure_place AS destination,
                                             WO.arrivial_place AS origin,
                                             WO.price AS price_per_passenger,
                                             WO.price_class AS price_class,
                                             R.return_date AS departure_date,
                                             R.return_time AS departure_time,
                                             R.number_of_seats,
                                             U.name,
                                             U.surname,
                                             U.sex,
                                             U.foto,
                                             U.face_check,
                                             U.birthyear,
                                             U.friends,
                                             L.level,
                                             L.tr_level,
                                             L.en_level,
                                             P.like_chat,
                                             P.like_pet,
                                             P.like_smoke,
                                             P.like_music,
                                             C.make,
                                             C.model,
                                             C.comfort,
                                             (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                             (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                             2 AS no  ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($whereTers)
		->order_by("R.return_date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();
		//echo "<br><br>Donus icin <br>";
		//echo $this->db->last_query();

		// NO:3 Çok seferlik seyahatlerden seç  Gidişler çin way pointsin içinde olmayanları seç
		// R -> events  T -> rutin_trip_dates
		$where2 = "( $one )         AND
                    R.trip_type = 1  AND
                    R.is_active = 1  AND
                    T.is_return = 0  AND
                    R.is_way    = 0  AND
                    CONCAT(T.date,' ',R.departure_time) >='{$date}' ";
		$query2 = $this->db->select('R.id AS event_id,
                                        T.id AS date_id,
                                        1 AS tip,
                                        0 AS is_way,
                                        R.created_at,
                                        WO.id,
                                        WO.departure_place AS origin,
                                        WO.arrivial_place AS destination,
                                        WO.price AS price_per_passenger,
                                        WO.price_class AS price_class,
                                        T.date AS departure_date,
                                        R.departure_time,
                                        R.number_of_seats,
                                        U.name,
                                        U.surname,
                                        U.birthyear,
                                        U.sex,
                                        U.foto,
                                        U.face_check,
                                        U.friends,
                                        L.level,
                                        L.tr_level,
                                        L.en_level,
                                        P.like_chat,
                                        P.like_pet,
                                        P.like_smoke,
                                        P.like_music,
                                        C.make,
                                        C.model,
                                        C.comfort,
                                        (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                        (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                        3 AS no ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($where2)
		->order_by("T.date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();

		//echo "Cok seferlik Gidis icin <br>";
		//echo $this->db->last_query();

		// NO:4 Çok seferlik DONUS çin  way pointsin içinde olmayanları seç
		// R -> events  T -> rutin_trip_dates
		$where2Ters = "( $oneReverse )  AND
                        R.trip_type = 1  AND
                        R.is_active = 1  AND
                        T.is_return = 1  AND
                        R.is_way    = 0  AND
                        CONCAT(T.date,' ',R.return_time) >='{$date}'";

		$query2Ters = $this->db->select('R.id AS event_id,
                                            T.id AS date_id,
                                            1 AS tip,
                                            0 AS is_way,
                                            WO.id,
                                            WO.departure_place AS destination,
                                            WO.arrivial_place AS origin,
                                            WO.price AS price_per_passenger,
                                            WO.price_class AS price_class,
                                            R.created_at,
                                            T.date AS departure_date,
                                            R.return_time AS departure_time,
                                            R.number_of_seats,
                                            U.name,
                                            U.surname,
                                            U.sex,
                                            U.foto,
                                            U.face_check,
                                            U.birthyear,
                                            U.friends,
                                            L.level,
                                            L.tr_level,
                                            L.en_level,
                                            P.like_chat,
                                            P.like_pet,
                                            P.like_smoke,
                                            P.like_music,
                                            C.make,
                                            C.model,
                                            C.comfort,
                                            ( SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                            ( SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                            4 AS no ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($where2Ters)
		->order_by("T.date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();

		//echo "Cok seferlik donus icin <br>";
		//echo $this->db->last_query();

		/****************************************************************************/
		/****************************************************************************/
		/*    CHANGE ALL OF THEM                                                    */
		/*****************************************************************************/
		/*****************************************************************************/
		/*****************************************************************************/
		/*****************************************************************************/

		// NO:5 Waypoints  Tek seferlik seyahatlerden seç Gidişler için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events   W -> way_points
		$where = "( $one )         AND
                   R.trip_type = 0  AND
                   R.is_active = 1  AND
                   R.is_way    = 1  AND
                   CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";
		$query3 = $this->db->select('R.id AS event_id,
                                        0 AS tip,
                                        1 AS is_way,
                                        R.created_at,
                                        WO.id,
                                        WO.departure_place AS origin,
                                        WO.arrivial_place AS destination,
                                        WO.price AS price_per_passenger,
                                        WO.price_class AS price_class,
                                        R.departure_date,
                                        R.departure_time,
                                        R.number_of_seats,
                                        U.name,
                                        U.surname,
                                        U.sex,
                                        U.foto,
                                        U.face_check,
                                        U.birthyear,
                                        U.friends,
                                        L.level,
                                        L.tr_level,
                                        L.en_level,
                                        P.like_chat,
                                        P.like_pet,
                                        P.like_smoke,
                                        P.like_music,
                                        C.make,
                                        C.model,
                                        C.comfort,
                                        (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                        (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                        5 AS no ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($where)
		->order_by("R.departure_date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();

		//echo "Gidiş için <br>";
		//echo $this->db->last_query();

		// NO:6 Waypoints Tek seferlik DONUS için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events   W -> way_points
		//Gereksiz `R`.`departure_date` AS `return_date`,
		//Gereksiz `R`.`departure_time` AS `return_time`,
		$whereTers = "( $oneReverse )   AND
                       R.trip_type = 0   AND
                       R.round_trip = 1  AND
                       R.is_active = 1   AND
                       R.is_way    = 1   AND
                       CONCAT(R.return_date,' ',R.return_time) >='{$date}' ";
		$query3Ters = $this->db->select('R.id AS event_id,
                                             0 AS tip,
                                             1 AS is_way,
                                             R.created_at,
                                             WO.id,
                                             WO.departure_place AS destination,
                                             WO.arrivial_place AS origin,
                                             WO.price AS price_per_passenger,
                                             WO.price_class AS price_class,
                                             R.return_date AS departure_date,
                                             R.return_time AS departure_time,
                                             R.number_of_seats,
                                             U.name,
                                             U.surname,
                                             U.sex,
                                             U.foto,
                                             U.face_check,
                                             U.birthyear,
                                             U.friends,
                                             L.level,
                                             L.tr_level,
                                             L.en_level,
                                             P.like_chat,
                                             P.like_pet,
                                             P.like_smoke,
                                             P.like_music,
                                             C.make,
                                             C.model,
                                             C.comfort,
                                             (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                             (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                             6 AS no  ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($whereTers)
		->order_by("R.return_date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();
		//echo "<br><br>Donus icin <br>";
		//echo $this->db->last_query();

		// NO:7 Waypoints Çok seferlik seyahatlerden seç Gidişler için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events  W -> way_points  T -> rutin_trip_dates
		$where2 = "( $one )         AND
                    R.trip_type = 1  AND
                    R.is_active = 1  AND
                    T.is_return = 0  AND
                    R.is_way    = 1  AND
                    CONCAT(T.date,' ',R.departure_time) >='{$date}' ";
		$query4 = $this->db->select('R.id AS event_id,
                                        T.id AS date_id,
                                        1 AS tip,
                                        1 AS is_way,
                                        R.created_at,
                                        WO.id,
                                        WO.departure_place AS origin,
                                        WO.arrivial_place AS destination,
                                        WO.price AS price_per_passenger,
                                        WO.price_class AS price_class,
                                        T.date AS departure_date,
                                        R.departure_time,
                                        R.number_of_seats,
                                        U.name,
                                        U.surname,
                                        U.birthyear,
                                        U.sex,
                                        U.foto,
                                        U.face_check,
                                        U.friends,
                                        L.level,
                                        L.tr_level,
                                        L.en_level,
                                        P.like_chat,
                                        P.like_pet,
                                        P.like_smoke,
                                        P.like_music,
                                        C.make,
                                        C.model,
                                        C.comfort,
                                        (SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                        (SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                        7 AS no ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($where2)
		->order_by("T.date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();

		//echo "Cok seferlik Gidis icin <br>";
		//echo $this->db->last_query();

		// NO:8 Waypoints  Çok seferlik  DONUS için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events  T -> rutin_trip_dates  W -> way_points
		$where2Ters = "( $oneReverse )  AND
                        R.trip_type = 1  AND
                        R.is_active = 1  AND
                        T.is_return = 1  AND
                        R.is_way    = 1  AND
                        CONCAT(T.date,' ',R.return_time) >='{$date}'";

		$query4Ters = $this->db->select('R.id AS event_id,
                                            T.id AS date_id,
                                            1 AS tip,
                                            1 AS is_way,
                                            WO.id,
                                            WO.departure_place AS destination,
                                            WO.arrivial_place AS origin,
                                            WO.price AS price_per_passenger,
                                            WO.price_class AS price_class,
                                            R.created_at,
                                            T.date AS departure_date,
                                            R.return_time AS departure_time,
                                            R.number_of_seats,
                                            U.name,
                                            U.surname,
                                            U.sex,
                                            U.foto,
                                            U.face_check,
                                            U.birthyear,
                                            U.friends,
                                            L.level,
                                            L.tr_level,
                                            L.en_level,
                                            P.like_chat,
                                            P.like_pet,
                                            P.like_smoke,
                                            P.like_music,
                                            C.make,
                                            C.model,
                                            C.comfort,
                                            ( SELECT AVG(rate) FROM ratings WHERE received_userid = U.id ) AS average,
                                            ( SELECT COUNT(id) FROM ratings WHERE received_userid = U.id ) AS number,
                                            8 AS no ', FALSE)
		->from('event_paths AS WO')
		->join('events AS R', 'WO.event_id = R.id')
		->join('users AS U', 'U.id = R.user_id')
		->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		->join('preferences AS P', 'U.id = P.user_id')
		->join('user_level AS L', 'U.level_id = L.level_id')
		->join('cars AS C', 'C.id = R.car_id')
		->where($where2Ters)
		->order_by("T.date", "asc")
		->limit($LIMIT, $OFFSET)
		->get();

		//echo "Cok seferlik donus icin <br>";
		//echo $this->db->last_query();

		if ($query1 && $query1Ters && $query2 && $query2Ters && $query3 && $query3Ters && $query4 && $query4Ters) {

			$result = $query1->result_array();// tek seferlik gidiş seyahatleri
			$resultTers = $query1Ters->result_array();// tek seferlik dönüş seyahatleri
			$result2 = $query2->result_array();// cok seferlik gidiş seyahatleri
			$result2Ters = $query2Ters->result_array();// cok seferlik dönüş seyahatleri
			$result3 = $query3->result_array();// Waypoints tek seferlik gidiş seyahatleri
			$result3Ters = $query3Ters->result_array();// Waypoints tek seferlik dönüş seyahatleri
			$result4 = $query4->result_array();// Waypoints çok seferlik gidiş seyahatleri
			$result4Ters = $query4Ters->result_array();// Waypoints çok seferlik dönüş seyahatleri

			// Waypoints Gidiş  Tek sefer
			foreach ($result3 as &$value) {
				$query2 = $this->db->select('W.id, W.departure_place, W.arrivial_place, W.distance, W.price')
				               ->where('event_id', $value['event_id'])
				               ->get('way_points AS W');
				if ($query2) {
					$allWays = $query2->result_array();
					$value['is_go'] = 1;
					$value['all_ways'] = $allWays;
				} else {

					return FALSE;
				}
			}

			// Waypoints Dönüş  Tek sefer
			foreach ($result3Ters as &$value) {
				$query2 = $this->db->select('W.id, W.departure_place, W.arrivial_place, W.distance, W.price')
				               ->where('event_id', $value['event_id'])
				               ->get('way_points AS W');
				if ($query2) {
					$allWays = $query2->result_array();
					$value['is_go'] = 0;
					$value['all_ways'] = $allWays;
				} else {

					return FALSE;
				}
			}

			// Waypoints Gidiş Çok sefer
			foreach ($result4 as &$value) {
				$query2 = $this->db->select('W.id, W.departure_place, W.arrivial_place, W.distance, W.price')
				               ->where('event_id', $value['event_id'])
				               ->get('way_points AS W');
				if ($query2) {
					$allWays = $query2->result_array();
					$value['is_go'] = 1;
					$value['all_ways'] = $allWays;
				} else {

					return FALSE;
				}
			}

			// Waypoints Dönüş Çok sefer
			foreach ($result4Ters as &$value) {
				$query2 = $this->db->select('W.id, W.departure_place, W.arrivial_place, W.distance, W.price')
				               ->where('event_id', $value['event_id'])
				               ->get('way_points AS W');
				if ($query2) {
					$allWays = $query2->result_array();
					$value['is_go'] = 0;
					$value['all_ways'] = $allWays;
				} else {

					return FALSE;
				}
			}

			// Merge results
			$searched = array_merge($result, $resultTers, $result2, $result2Ters,
				$result3, $result3Ters, $result4, $result4Ters);

			// Display results
			// $this-> display( $result, $resultTers, $result2, $result2Ters, $result3, $result3Ters, $result4, $result4Ters, $searched );

			return $searched;// return search results
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
	function searchCount($origin, $destination, $lat, $lng, $dLat, $dLng, $range, $LIMIT, $OFFSET) {

		$date = date('Y-m-d H:i:s');// current date
		// tip 0 tekseferlik yolculuk event_id
		// tip 1 çok seferli yolculuk  date_id
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
		$second = $twoway ? "AND ( WO.dLat >= $min_dLat  AND  WO.dLat <= $max_dLat AND  WO.dLng >= $min_dLng  AND  WO.dLng <= $max_dLng )" : "";
		$one = "( WO.departure_place LIKE '%$origin%' AND  WO.arrivial_place LIKE '%$destination%' )  OR
                    (  ( WO.lat >= $min_lat  AND  WO.lat <= $max_lat AND WO.lng >= $min_lng  AND  WO.lng <= $max_lng)
$second
                     ) ";

		// tersleri için
		$secondReverse = $twoway ? "AND ( WO.lat >= $min_dLat  AND  WO.lat <= $max_dLat AND WO.lng >= $min_dLng  AND  WO.lng <= $max_dLng )" : "";
		$oneReverse = "( WO.departure_place LIKE '%$destination%' AND  WO.arrivial_place LIKE '%$origin%' )  OR
                            (  ( WO.dLat >= $min_lat  AND  WO.dLat <= $max_lat AND  WO.dLng >= $min_lng  AND  WO.dLng <= $max_lng)
$secondReverse
                             ) ";
		// NO:1 Tek seferlik GİDİŞ için  way pointsin içinde olmayanları seç
		// R -> events
		$where = "( $one )         AND
                   R.trip_type = 0  AND
                   R.is_active = 1  AND
                   R.is_way    = 0  AND
                   CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";
		$query1 = $this->db->select('COUNT(R.id) AS num')
		               ->from('event_paths AS WO')
		               ->join('events AS R', 'WO.event_id = R.id')
		               ->join('users AS U', 'U.id = R.user_id')
		               ->join('preferences AS P', 'U.id = P.user_id')
		               ->join('user_level AS L', 'U.level_id = L.level_id')
		               ->join('cars AS C', 'C.id = R.car_id')
		               ->where($where)
		               ->get();

		//echo "Gidiş için <br>";
		//echo $this->db->last_query();
		// NO:2  Tek seferlik DONUS için  way pointsin içinde olmayanları seç
		// R -> events
		$whereTers = "( $oneReverse )   AND
                       R.trip_type = 0   AND
                       R.round_trip = 1  AND
                       R.is_active = 1   AND
                       R.is_way    = 0   AND
                       CONCAT(R.return_date,' ',R.return_time) >='{$date}' ";
		$query1Ters = $this->db->select('COUNT(R.id) AS num')
		                   ->from('event_paths AS WO')
		                   ->join('events AS R', 'WO.event_id = R.id')
		                   ->join('users AS U', 'U.id = R.user_id')
		                   ->join('preferences AS P', 'U.id = P.user_id')
		                   ->join('user_level AS L', 'U.level_id = L.level_id')
		                   ->join('cars AS C', 'C.id = R.car_id')
		                   ->where($whereTers)
		                   ->get();
		//echo "<br><br>Donus icin <br>";
		//echo $this->db->last_query();
		// NO:3 Çok seferlik seyahatlerden seç  Gidişler çin way pointsin içinde olmayanları seç
		// R -> events  T -> rutin_trip_dates
		$where2 = "( $one )         AND
                    R.trip_type = 1  AND
                    R.is_active = 1  AND
                    T.is_return = 0  AND
                    R.is_way    = 0  AND
                    CONCAT(T.date,' ',R.departure_time) >='{$date}' ";
		$query2 = $this->db->select('COUNT(R.id) AS num')
		               ->from('event_paths AS WO')
		               ->join('events AS R', 'WO.event_id = R.id')
		               ->join('users AS U', 'U.id = R.user_id')
		               ->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		               ->join('preferences AS P', 'U.id = P.user_id')
		               ->join('user_level AS L', 'U.level_id = L.level_id')
		               ->join('cars AS C', 'C.id = R.car_id')
		               ->where($where2)
		               ->get();

		//echo "Cok seferlik Gidis icin <br>";
		//echo $this->db->last_query();
		// NO:4 Çok seferlik DONUS çin  way pointsin içinde olmayanları seç
		// R -> events  T -> rutin_trip_dates
		$where2Ters = "( $oneReverse )  AND
                        R.trip_type = 1  AND
                        R.is_active = 1  AND
                        T.is_return = 1  AND
                        R.is_way    = 0  AND
                        CONCAT(T.date,' ',R.return_time) >='{$date}'";
		$query2Ters = $this->db->select('COUNT(R.id) AS num')
		                   ->from('event_paths AS WO')
		                   ->join('events AS R', 'WO.event_id = R.id')
		                   ->join('users AS U', 'U.id = R.user_id')
		                   ->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		                   ->join('preferences AS P', 'U.id = P.user_id')
		                   ->join('user_level AS L', 'U.level_id = L.level_id')
		                   ->join('cars AS C', 'C.id = R.car_id')
		                   ->where($where2Ters)
		                   ->get();

		//echo "Cok seferlik donus icin <br>";
		//echo $this->db->last_query();

		/****************************************************************************/
		/****************************************************************************/
		/*    CHANGE ALL OF THEM                                                    */
		/*****************************************************************************/
		/*****************************************************************************/
		/*****************************************************************************/
		/*****************************************************************************/

		// NO:5 Waypoints  Tek seferlik seyahatlerden seç Gidişler için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events   W -> way_points
		$where = "( $one )         AND
                   R.trip_type = 0  AND
                   R.is_active = 1  AND
                   R.is_way    = 1  AND
                   CONCAT(R.departure_date,' ',R.departure_time) >='{$date}' ";
		$query3 = $this->db->select('COUNT(R.id) AS num')
		               ->from('event_paths AS WO')
		               ->join('events AS R', 'WO.event_id = R.id')
		               ->join('users AS U', 'U.id = R.user_id')
		               ->join('preferences AS P', 'U.id = P.user_id')
		               ->join('user_level AS L', 'U.level_id = L.level_id')
		               ->join('cars AS C', 'C.id = R.car_id')
		               ->where($where)
		               ->get();

		//echo "Gidiş için <br>";
		//echo $this->db->last_query();
		// NO:6 Waypoints Tek seferlik DONUS için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events   W -> way_points
		//Gereksiz `R`.`departure_date` AS `return_date`,
		//Gereksiz `R`.`departure_time` AS `return_time`,
		$whereTers = "( $oneReverse )   AND
                       R.trip_type = 0   AND
                       R.round_trip = 1  AND
                       R.is_active = 1   AND
                       R.is_way    = 1   AND
                       CONCAT(R.return_date,' ',R.return_time) >='{$date}' ";
		$query3Ters = $this->db->select('COUNT(R.id) AS num')
		                   ->from('event_paths AS WO')
		                   ->join('events AS R', 'WO.event_id = R.id')
		                   ->join('users AS U', 'U.id = R.user_id')
		                   ->join('preferences AS P', 'U.id = P.user_id')
		                   ->join('user_level AS L', 'U.level_id = L.level_id')
		                   ->join('cars AS C', 'C.id = R.car_id')
		                   ->where($whereTers)
		                   ->get();
		//echo "<br><br>Donus icin <br>";
		//echo $this->db->last_query();
		// NO:7 Waypoints Çok seferlik seyahatlerden seç Gidişler için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events  W -> way_points  T -> rutin_trip_dates
		$where2 = "( $one )         AND
                    R.trip_type = 1  AND
                    R.is_active = 1  AND
                    T.is_return = 0  AND
                    R.is_way    = 1  AND
                    CONCAT(T.date,' ',R.departure_time) >='{$date}' ";
		$query4 = $this->db->select('COUNT(R.id) AS num')
		               ->from('event_paths AS WO')
		               ->join('events AS R', 'WO.event_id = R.id')
		               ->join('users AS U', 'U.id = R.user_id')
		               ->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		               ->join('preferences AS P', 'U.id = P.user_id')
		               ->join('user_level AS L', 'U.level_id = L.level_id')
		               ->join('cars AS C', 'C.id = R.car_id')
		               ->where($where2)
		               ->get();

		//echo "Cok seferlik Gidis icin <br>";
		//echo $this->db->last_query();
		// NO:8 Waypoints  Çok seferlik  DONUS için  farklı way points deki gidiş ve geliş yeri için arama yapılcak
		// R -> events  T -> rutin_trip_dates  W -> way_points
		$where2Ters = "( $oneReverse )  AND
                        R.trip_type = 1  AND
                        R.is_active = 1  AND
                        T.is_return = 1  AND
                        R.is_way    = 1  AND
                        CONCAT(T.date,' ',R.return_time) >='{$date}'";
		$query4Ters = $this->db->select('COUNT(R.id) AS num')
		                   ->from('event_paths AS WO')
		                   ->join('events AS R', 'WO.event_id = R.id')
		                   ->join('users AS U', 'U.id = R.user_id')
		                   ->join('rutin_trip_dates AS T', 'T.event_id = R.id')
		                   ->join('preferences AS P', 'U.id = P.user_id')
		                   ->join('user_level AS L', 'U.level_id = L.level_id')
		                   ->join('cars AS C', 'C.id = R.car_id')
		                   ->where($where2Ters)
		                   ->get();

		//echo "Cok seferlik donus icin <br>";
		//echo $this->db->last_query();
		if ($query1 && $query1Ters && $query2 && $query2Ters && $query3 && $query3Ters && $query4 && $query4Ters) {

			$result = $query1->result_array();// tek seferlik gidiş seyahatleri
			$resultTers = $query1Ters->result_array();// tek seferlik dönüş seyahatleri
			$result2 = $query2->result_array();// cok seferlik gidiş seyahatleri
			$result2Ters = $query2Ters->result_array();// cok seferlik dönüş seyahatleri
			$result3 = $query3->result_array();// Waypoints tek seferlik gidiş seyahatleri
			$result3Ters = $query3Ters->result_array();// Waypoints tek seferlik dönüş seyahatleri
			$result4 = $query4->result_array();// Waypoints çok seferlik gidiş seyahatleri
			$result4Ters = $query4Ters->result_array();// Waypoints çok seferlik dönüş seyahatleri

			// Merge results
			$searched = array_merge($result, $resultTers, $result2, $result2Ters,
				$result3, $result3Ters, $result4, $result4Ters);

			$count = 0;
			foreach ($searched as $val) {
				$count += $val['num'];
			}

			return $count;// return search results total count
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

		if ($query1 && $query2) {
			return array('last' => $query1->result_array(),
				'today' => $query2->result_array(),
				'best' => array());
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
