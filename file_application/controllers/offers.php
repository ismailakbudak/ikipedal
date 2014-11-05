<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}
/**
 *
 * Offers Controller
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      İsmail AKBUDAK
 * @link        http://ismailakbudak.com
 *
 */
class Offers extends CI_Controller {
	/**
	 *  global variable
	 **/
	public $userid;
	/**
	 *  Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->lang->load('offers');
		// decode user id or set 0
		if ($this->session->userdata('logged_in')) {
			$this->userid = $this->encrypt->decode($this->session->userdata('userid'));
		} else {
			$this->userid = 0;
		}
	}
	/**
	 * Teklif verme sayfasının ilk bölümü
	 *
	 * @return HTML view
	 **/
	public function newest() {
		$this->load->model('event_types');// load offers model
		$types = $this->event_types->Get();
		if (is_array($types)) {
			$this->login->general();// call general load view
			$data['event_types'] = $types;
			$this->load->view('offers/new', $data);// load view
			$this->load->view('include/footer');// load view
		} else {
			show_404();
		}
	}
	/**
	 * AJAX function
	 * Teklif oluşturma işlemi 1.sayfa için triptype 0
	 *
	 * @return JSON output status : success, fail, error
	 **/
	public function create() {
		if ($this->session->userdata('logged_in')) {
			$this->load->helper("ajax");
			$this->form->check(lang('oc.trip_type'), 'trip_type', 'required|xss_clean');// check post data
			$this->form->check(lang('oc.round_trip'), 'round_trip', 'required|xss_clean');// check post data
			$this->form->check(lang('oc.inputName'), 'name', 'required|max_length[100]|xss_clean');// check post data
			$this->form->check(lang('oc.event_type'), 'event_type', 'required|integer|xss_clean');// check post data
			$this->form->check(lang('oc.explain_departure'), 'explain_departure', 'max_length[250]|xss_clean');// check post data
			$this->form->check(lang('oc.origin'), 'origin', 'required|max_length[100]|xss_clean');// check post data
			$this->form->check(lang('oc.destination'), 'destination', 'required|max_length[100]|xss_clean');// check post data
			$this->form->check(lang('oc.way_points'), 'way_points', 'waypoints_match|xss_clean');// check post data
			$this->form->check(lang('oc.departure_date'), 'departure_date', 'required|is_date|exact_length[10]|xss_clean');// check post data
			$this->form->check(lang('oc.departure_time'), 'departure_time', 'required|is_time|exact_length[5] |xss_clean');// check post data
			if ($this->input->post('round_trip', TRUE) == "true") {// is trip twoway
				$this->form->check(lang('oc.return_date'), 'return_date', 'required|is_date|exact_length[10]|xss_clean');// check post data
				$this->form->check(lang('oc.return_time'), 'return_time', 'required|is_time|exact_length[5] |xss_clean');// check post data
				$date1 = trim($this->input->post('departure_date', TRUE)) . " " . trim($this->input->post('departure_time', TRUE));
				$date2 = trim($this->input->post('return_date', TRUE)) . " " . trim($this->input->post('return_time', TRUE));
				$this->form->date_compare($date1, $date2, lang("oc.departure"), lang("oc.return"));// compare my dates if return date doe not after the departure date return false
			}
			$this->form->check(lang('oc.DistancesWay'), 'DistancesWay', 'regex_match[/^([0-9 .?])+$/i]|xss_clean');// check post data
			$this->form->check(lang('oc.TimesWay'), 'TimesWay', 'waypoints_match|xss_clean');// check post data
			$this->form->check(lang('oc.totalDistance'), 'total_distance', 'waypoints_match|xss_clean');// check post data
			$this->form->check(lang('oc.totalTime'), 'total_time', 'waypoints_match|xss_clean');// check post data
			$this->form->check(lang('oc.locations'), 'locations', 'check_array|xss_clean');// check post data
			$this->form->check_names('origin', 'destination', 'way_points');
			if ($this->form->get_result()) {
				$post_user_id = $this->encrypt->decode($this->session->userdata('userid'));// decode userid
				$post_way_points = $this->input->post('way_points', TRUE);// waypoints name like istanbul?Denizli
				$post_round_trip = $this->input->post('round_trip', TRUE);// two way or one way trip
				$post_input_distances = $this->input->post('DistancesWay', TRUE);// waypoints distances like 234km?221km
				$post_input_times = $this->input->post('TimesWay', TRUE);// waypoints distance hour like 34 dk?3 saat
				//added after
				$locations = $this->input->post('locations', TRUE);
				$is_way = (trim($post_way_points) == "") ? 0 : 1;
				$post_round_trip = (strcmp($post_round_trip, 'true') == 0) ? 1 : 0;// trip is two way or not
				$event = array('user_id' => $post_user_id, // create offer model for database
					'name' => $this->input->post('name', TRUE),
					'event_type_id' => $this->input->post('event_type', TRUE),
					'is_way' => $is_way,
					'trip_type' => $this->input->post('trip_type', TRUE),
					'origin' => $this->input->post('origin', TRUE),
					'destination' => $this->input->post('destination', TRUE),
					'way_points' => $post_way_points,
					'departure_date' => $this->input->post('departure_date', TRUE),
					'departure_time' => $this->input->post('departure_time', TRUE),
					'return_date' => $this->input->post('return_date', TRUE),
					'return_time' => $this->input->post('return_time', TRUE),
					'round_trip' => $post_round_trip,
					'total_distance' => $this->input->post('total_distance', TRUE),
					'total_time' => $this->input->post('total_time', TRUE),
					'explain_departure' => $this->input->post('explain_departure', TRUE),
				);
				$ways_offer = array();
				if ($is_way) {// way points is null or not
					$points = explode('?', $post_way_points);// way points split
					$distances = explode('?', $post_input_distances);// way points distance split
					$times = explode('?', $post_input_times);// way points distances time split
					$waypoint = array('o_from' => $event['origin'],
						'd_to' => $points[0],
						'distance' => $distances[0],
						'time' => $times[0]);
					$ways_offer[] = $waypoint;
					for ($i = 0; $i < count($points) - 1;
						$i++) {
						$waypoint = array('o_from' => $points[$i],
							'd_to' => $points[$i + 1],
							'distance' => $distances[$i + 1],
							'time' => $times[$i + 1]);
						$ways_offer[] = $waypoint;
					}
					$waypoint = array('o_from' => $points[count($points) - 1],
						'd_to' => $event['destination'],
						'distance' => $distances[count($distances) - 1],
						'time' => $times[count($times) - 1]);
					$ways_offer[] = $waypoint;
				}
				// Add main travel
				$ways_offer[] = array('o_from' => $event['origin'],
					'd_to' => $event['destination'],
					'distance' => $event['total_distance'],
					'time' => $event['total_time'],
				);
				// Get locations of points
				foreach ($ways_offer as &$value) {
					$result = getLocation($value, $locations);
				}
				$this->load->model('offersdb');// load offersdb model
				$offer_id = $this->offersdb->saveOffer($event, $ways_offer);
				if ($offer_id) {// offer has been saved succesfully unset session data
					$origin = $event['origin'];
					$destination = $event['destination'];
					$origin = explode(',', $origin);
					$origin = $origin[0];
					$destination = explode(',', $destination);
					$destination = $destination[0];
					$name = urlCreate($this->lang->lang(), $origin, $destination, $offer_id);
					$status = 'success';
				} else {
					$status = "fail";
					$name = "null";
				}
			} else {
				$status = "error";
				$name = "null";
			}
			$error = $this->form->get_error();//  if there is error get it from Form validation class
		} else {
			$status = "login";
			$error['message'] = 'Please login';
			$name = "null";
		}
		$result = array('status' => $status, // JSON output
			'message' => $error['message'],
			'path' => $name);
		echo json_encode($result);// JSON output
	}

	/**
	 *  Arama verilerini kaydet ve sayfayı yönlendir
	 *
	 *  @return  redirect
	 **/
	public function redirect() {
		$origin = $this->security->xss_clean(trim($this->input->get('origin')));// get GET[] data from URL
		$lat = $this->security->xss_clean($this->input->get('lat'));// get GET[] data from URL
		$lng = $this->security->xss_clean($this->input->get('lng'));// get GET[] data from URL
		$originStatus = $this->security->xss_clean($this->input->get('originStatus'));// get GET[] data from URL
		$destination = $this->security->xss_clean(trim($this->input->get('destination')));// get GET[] data from URL
		$dLat = $this->security->xss_clean($this->input->get('dLat'));// get GET[] data from URL
		$dLng = $this->security->xss_clean($this->input->get('dLng'));// get GET[] data from URL
		$destinationStatus = $this->security->xss_clean($this->input->get('destinationStatus'));// get GET[] data from URL
		$range = $this->security->xss_clean($this->input->get('range'));// get GET[] data from URL
		// if origin value is not set, redirect user to search page
		if (strcmp($originStatus, "1") != 0 || strcmp($origin, "") == 0 || strcmp($lat, "") == 0 || strcmp($lng, "") == 0 || !isset($lat) || !isset($lng) || $lat <= 0 || $lng <= 0)// check origin point is set
		{
			redirect("main");
		}
		// check destination data is set
		if (strcmp($destinationStatus, "1") != 0 || strcmp($destination, "") == 0 || $dLat <= 0 || $dLng <= 0) {
			$destination = "";
			$destinationStatus = 0;
			$dLat = -1;
			$dLng = -1;
		} 
		$sessionOrigin = $origin;
		$sessionDestination = $destination;
		$origin = explode(",", $origin);
		$destination = explode(",", $destination);
		$iller = array("ADANA", "ADIYAMAN", "AFYONKARAHISAR", "AĞRI", "AMASYA", "ANKARA", "ANTALYA", "ARTVIN", "AYDIN", "BALIKESIR", "BILECIK", "BINGÖL", "BITLIS", "BOLU", "BURDUR", "BURSA", "ÇANAKKALE", "ÇANKIRI", "ÇORUM", "DENIZLI", "DIYARBAKIR", "EDIRNE", "ELAZIĞ", "ERZINCAN", "ERZURUM", "ESKIŞEHIR", "GAZIANTEP", "GIRESUN", "GÜMÜŞHANE", "HAKKARI", "HATAY", "ISPARTA", "MERSIN", "ISTANBUL", "IZMIR", "KARS", "KASTAMONU", "KAYSERI", "KIRKLARELI", "KIRŞEHIR", "KOCAELI", "KONYA", "KÜTAHYA", "MALATYA", "MANISA", "KAHRAMANMARAŞ", "MARDIN", "MUĞLA", "MUŞ", "NEVŞEHIR", "NIĞDE", "ORDU", "RIZE", "SAKARYA", "SAMSUN", "SIRT", "SINOP", "SIVAS", "TEKIRDAĞ", "TOKAT", "TRABZON", "TUNCELI", "ŞANLIURFA", "UŞAK", "VAN", "YOZGAT", "ZONGULDAK", "AKSARAY", "BAYBURT", "KARAMAN", "KIRIKKALE", "BATMAN", "ŞIRNAK", "BARTIN", "ARDAHAN", "IĞDIR", "YALOVA", "KARABÜK", "KILIS", "OSMANIYE", "DÜZCE");
		$place1 = "";
		$flag1 = FALSE;
		$flag2 = FALSE;
		$place2 = "";
		foreach ($origin as $value) {
			if (in_array(mb_strtoupper(mb_strtolower(trim($value), 'utf-8'), 'utf-8'), $iller)) {
				$place1 = trim($value);
				$flag1 = TRUE;
				break;
			}
		}
		foreach ($destination as $value) {
			if (in_array(mb_strtoupper(mb_strtolower(trim($value), 'utf-8'), 'utf-8'), $iller)) {
				$place2 = trim($value);
				$flag2 = TRUE;
				break;
			}
		}
		if (!$flag1) {
			$place1 = trim($origin[0]);
		}
		if (!$flag2) {
			$place2 = trim($destination[0]);
		}
		$searchData = array('offerInfo' => 1,
			'offerAlertSave' => 0,
			'countOffer' => 1,
			'origin' => $sessionOrigin,
			'lat' => $lat,
			'lng' => $lng,
			'originStatus' => $originStatus,
			'destination' => $sessionDestination,
			'dLat' => $dLat,
			'dLng' => $dLng,
			'destinationStatus' => $destinationStatus,
			'place1' => $place1,
			'place2' => $place2,
			'range' => $range);
		$this->session->set_userdata($searchData);
		$query = "origin=$place1&lat=$lat&lng=$lng&destination=$place2&dLat=$dLat&dLng=$dLng&originStatus=$originStatus&destinationStatus=$destinationStatus&range=$range";
		if (strcmp(lang('lang'), "tr") == 0) {
			redirect("ara-seyahat-sonuc?$query");
		} else {
			redirect("search-travel-result?$query");
		}
	}

	/**
	 *  Tarihe gore arama verileri
	 *
	 *  @return  view
	 **/
	public function searchByDate( $null='', $page = '1' ) {
		$event_date = $this->security->xss_clean(trim($this->input->get('date')));// get GET[] data from URL
		$this->lang->load('main'); 
		$this->load->helper("offer_detail_search");
		if ( strcmp('',  trim($event_date)) == 0 &&  strcmp('',  trim($this->session->userdata('offer_date'))) == 0 ){  
			redirect("main");
		}
		else if ( strcmp('',  trim($event_date)) != 0 ){
		    $date = date('Y-m-d',   $event_date );
		    $search_data = array('offer_date' => $event_date );
			$this->session->set_userdata($search_data);
	    }else{
	    	$event_date = $this->session->userdata('offer_date');
	    	$date = date('Y-m-d', $event_date);
	    }  

		$this->load->model('offersdb');// load offersdb model for database action
		$this->load->model('users');// load users model for database action
		$this->load->helper('search');
		$counts = $this->offersdb->searchCountDate($date);

		// Pagination
		$this->load->library('pagination');
		$config['base_url']         =  ( strcmp(lang('lang'), 'tr') == 0 ? new_url('ara-seyahat-tarih-sonuc' ) : new_url('search-travel-date-result' ) ); 
		$config['total_rows']       = $counts;
		$config['per_page']         = 30;
		//$config['uri_segment']      = 3; 
        if (strcmp(lang('lang'), "tr") == 0) {        
        	$config['first_link'   ]  = '&lsaquo; İlk'; 
	        $config['last_link'	   ]  = 'Son &rsaquo;';
	    }else{
	    	$config['first_link'   ]  = '&lsaquo; First'; 
	        $config['last_link'	   ]  = 'Last &rsaquo;';
	    }    
		$this->pagination->initialize($config);
		$results = $this->offersdb->searchDate($date, $page,  $per_page = $config['per_page']   );
		if (is_array($results)  ) {
			$on                      = 'departure_date';
			$results                 = array_sort($results, $on, $order = SORT_ASC);
			$data['getDataUrl']      = $event_date; 
			$data['results']         = $results;
			$data['counts']          = $counts; 
			$this->lang->load('search');// load language file
			$this->login->general($data);// load views
			$this->load->view('main/searchResultDate');// load views
			$this->load->view('include/footer');// load views
		} else {
			show_404('offer');
		} 

	} 

	/**
	 * Arama sonuçlarını göster
	 *
	 *
	 * @return HTML views
	 **/
	public function search($null = '', $page = '1') { 
		$this->lang->load('main');
		$this->load->helper("offer_detail_search");
		$origin = $this->security->xss_clean(trim($this->input->get('origin')));// get GET[] data from URL
		$lat = $this->security->xss_clean($this->input->get('lat'));// get GET[] data from URL
		$lng = $this->security->xss_clean($this->input->get('lng'));// get GET[] data from URL
		$originStatus = $this->security->xss_clean($this->input->get('originStatus'));// get GET[] data from URL
		$destination = $this->security->xss_clean(trim($this->input->get('destination')));// get GET[] data from URL
		$dLat = $this->security->xss_clean($this->input->get('dLat'));// get GET[] data from URL
		$dLng = $this->security->xss_clean($this->input->get('dLng'));// get GET[] data from URL
		$destinationStatus = $this->security->xss_clean($this->input->get('destinationStatus'));// get GET[] data from URL
		$range = $this->security->xss_clean($this->input->get('range'));// get GET[] data from URL
		if (strcmp($originStatus, "1") != 0 && strcmp($origin, "") == 0 && $this->session->userdata('offerInfo')) {
			$origin = $this->session->userdata('place1');// get GET[] data from URL
			$lat = $this->session->userdata('lat');// get GET[] data from URL
			$lng = $this->session->userdata('lng');// get GET[] data from URL
			$originStatus = $this->session->userdata('originStatus');// get GET[] data from URL
			$destination = $this->session->userdata('place2');// get GET[] data from URL
			$dLat = $this->session->userdata('dLat');// get GET[] data from URL
			$dLng = $this->session->userdata('dLng');// get GET[] data from URL
			$destinationStatus = $this->session->userdata('destinationStatus');// get GET[] data from URL
		} 
		// if origin value is not set, redirect user to search page
		if (  strcmp($originStatus, "1") != 0 || strcmp($origin, "") == 0 || strcmp($lat, "") == 0 || strcmp($lng, "") == 0 || !isset($lat) || !isset($lng) || $lat <= 0 || $lng <= 0){  
			redirect("main");
		} 
		// check destination data is set
		if (strcmp($destinationStatus, "1") != 0 || strcmp($destination, "") == 0 || $dLat <= 0 || $dLng <= 0) {
			$destination = "";
			$destinationStatus = 0;
			$dLat = -1;
			$dLng = -1;
		}
		$this->load->model('offersdb');// load offersdb model for database action
		$this->load->model('users');// load users model for database action
		$this->load->helper('search');
		$counts = $this->offersdb->searchCount($origin, $destination, $lat, $lng, $dLat, $dLng, $range);

		// Pagination
		$this->load->library('pagination');
		$config['base_url']         =  ( strcmp(lang('lang'), 'tr') == 0 ? new_url('ara-seyahat-sonuc') : new_url('search-travel-result') );   
		$config['total_rows']       = $counts;
		$config['per_page']         = 30;
		//$config['uri_segment']      = 3; 
        if (strcmp(lang('lang'), "tr") == 0) {        
        	$config['first_link'   ]  = '&lsaquo; İlk'; 
	        $config['last_link'	   ]  = 'Son &rsaquo;';
	    }else{
	    	$config['first_link'   ]  = '&lsaquo; First'; 
	        $config['last_link'	   ]  = 'Last &rsaquo;';
	    }    
		$this->pagination->initialize($config);
		
		$results = $this->offersdb->search($origin, $destination, $lat, $lng, $dLat, $dLng, $range, $page, $per_page = $config['per_page']   );
		if (is_array($results)  ) {
			$on                      = 'departure_date';
			$results                 = array_sort($results, $on, $order = SORT_ASC);
			$urlString               = "?origin=$origin&lat=$lat&lng=$lng&destination=$destination&dLat=$dLat&dLng=$dLng&originStatus=$originStatus&destinationStatus=$destinationStatus&range=$range";
			$urlWithoutRange         = "?origin=$origin&lat=$lat&lng=$lng&destination=$destination&dLat=$dLat&dLng=$dLng&originStatus=$originStatus&destinationStatus=$destinationStatus";
			$data['getDataUrl']      = $urlString;
			$data['urlWithoutRange'] = $urlWithoutRange;
			$data['range']           = $range;
			$data['x1']              = $lat;
			$data['x2']              = $dLat;
			$data['y1']              = $lng;
			$data['y2']              = $dLng;
			$data['status1']         = $originStatus;
			$data['status2']         = $destinationStatus; 
			$data['origin']          = $origin;
			$data['destination']     = $destination;
			$data['results']         = $results;
			$data['counts']          = $counts; 
			$this->lang->load('search');// load language file
			$this->login->general($data);// load views
			$this->load->view('main/searchResult');// load views
			$this->load->view('include/footer');// load views
		} else {
			show_404('offer');
		}
	}
	/**
	 * AJAX function
	 * AJAX ile arama verilerini yükle
	 *
	 * @return JSON $array teklif listesi
	 **/
	function searchAjax($OFFSET) {
		$origin = $this->security->xss_clean(trim($this->input->get('origin')));// get GET[] data from URL
		$lat = $this->security->xss_clean($this->input->get('lat'));// get GET[] data from URL
		$lng = $this->security->xss_clean($this->input->get('lng'));// get GET[] data from URL
		$originStatus = $this->security->xss_clean($this->input->get('originStatus'));// get GET[] data from URL
		$destination = $this->security->xss_clean(trim($this->input->get('destination')));// get GET[] data from URL
		$dLat = $this->security->xss_clean($this->input->get('dLat'));// get GET[] data from URL
		$dLng = $this->security->xss_clean($this->input->get('dLng'));// get GET[] data from URL
		$destinationStatus = $this->security->xss_clean($this->input->get('destinationStatus'));// get GET[] data from URL
		$range = $this->security->xss_clean($this->input->get('range'));// get GET[] data from URL
		// check origin point is set
		if (strcmp($originStatus, "1") == 0 && strcmp($origin, "") != 0 && is_numeric($OFFSET) && $OFFSET != 0) {
			// check destination data is set
			if (strcmp($destinationStatus, "1") != 0 || strcmp($destination, "") == 0) {
				$destination = "";
			}
			$this->load->model('offersdb');// load offersdb model for database action
			$this->load->helper('search');
			$this->lang->load('search');// load language file
			$limit = 3;
			$offset = $OFFSET;
			$offers = $this->offersdb->search($origin, $destination, $lat, $lng, $dLat, $dLng, $range, $limit, $offset);
			if (is_array($offers)) {
				$on = 'departure_date';
				$results = array_sort($offers, $on, $order = SORT_ASC);
				$offset = $OFFSET + $limit;
				if (count($offers) > 0) {
					$date = date('Y');
					$countPrice = $results['countPrice'];
					$offers = array();
					foreach ($results['offers'] as $v) {
						$offers[] = writeOffer($v, $date, $countPrice, $offset);
					}
					$results['countPrice'] = $countPrice;
					$results['offers'] = $offers;
				} else {
					$results['offers'] = array();
				}
				$status = "success ";
			} else {
				$status = "error";
			}
		} else {
			// origin not initialized
			$status = "error";
		}
		$result = array('status' => $status, // JSON output
			'results' => isset($results) ? $results : array(),
			'text' => isset($text) ? $text : "");
		echo json_encode($result);// JSON output
	}
	/**
	 * Arama sayfasından alınan veriler ile teklif detaylarını göster
	 *
	 * @param  $url_title
	 * @return HTML view
	 * tip 0 -> ride_offer_id,  1 -> date_id
	 **/
	public function detail($url_title) {
		if (!isset($url_title)) {
			show_404('offer');
		}
		$url = explode("-", $url_title);
		if (count($url) == 3) {
			$this->load->helper('offer_detail_search');// load offer_detail_helper file
			$this->load->model('offersdb');// load offersdb model for database action
			$this->load->model('look_at');// load look_at model for database action
			$origin = trim($url[0]);
			$destination = trim($url[1]);
			$id = $url[2];
			$lang = lang('lang');

			if (!is_numeric($id) || strcmp('', $origin) == 0 || strcmp('', $destination) == 0) {
				show_404('offer');exit;
			}
			$offer = $this->offersdb->GetOfferForSearchResult($id);// get users up-date offers   $user_id, $numrows, $start
			if (is_array($offer) && count($offer) > 0) {
				$offer['user']['foto'] = photoCheckUser($offer['user']);// check photo car is exist
				foreach ($offer['user']['ratings'] as &$value) {
					$value['foto'] = photoCheckUser($value);
				}
				//done check offer does belongs to login user if not add look_at new model
				// check offer does belongs to login user if not add look_at new model
				$data['own_offer'] = (strcmp($this->userid, $offer['user_id']) == 0) ? 1 : 0;// this offer is it belong to session user
				if (!$data['own_offer']) {
					$link = strcmp($lang, "tr") == 0 ? "seyahat-" : "travel-";
					$link .= $url_title;// if offer does not belong to logined user
					$this->look_at->add(array('event_id' => $offer['id'],
						'origin' => $offer['origin'],
						'destination' => $offer['destination'],
						'user_id' => $this->userid,
						'path' => $link));// add new look_at model
				}
				$data['offer'] = $offer;// send offer to view
				$this->login->general($data);// load views
				$this->load->view('offers/show');// load views
				$this->load->view('include/footer');// load views
			} else {// offer alınırken hata oluştu
				show_404('offer');// show error page
			}
		} else {
			show_404('offer');// show error page
		}
	}
	/**
	 *  Teklife gözatanları listeler
	 *
	 *  @param  $offerid şifrelenmiş teklif id
	 *  @return HTML view
	 **/
	public function showList($offerid) {
		if (!isset($offerid)) {
			show_404();
			exit();
		}
		$this->data['active_side'] = '';// active sidebar menu
		$this->load->model('offersdb');// load offersdb model for database action
		$this->load->model('look_at');// load look_at model for database action
		$this->load->model('event_paths');// load event_paths model for database action 
		$this->load->helper("offer");// load helper file for action
		$where = array('id' => $offerid);
		$offer = $this->offersdb->GetWhere($where);// get users up-date offers   $user_id, $numrows, $start
		$look_list = $this->look_at->GetLookList($offerid);// get look list user
		if (is_array($offer) && count($offer) > 0 && is_array($look_list)) {
			$waypoints = $this->event_paths->GetOfferWays($offer['id']);// get offer waypoints
			if (is_array($waypoints)) {
				$offer['event_paths'] = $waypoints;
				foreach ($look_list as $value) {
					$value['foto'] = photoCheckUser($value);
				}
				$offer['look_list'] = $look_list;// send look list to view
				$look_count = $this->look_at->GetLookCount($offer['id']);// get looked people count for this offerid
				if (is_array($look_count) && count($look_count) > 0) {
					$offer['look_count'] = $look_count;
				} else {
					$offer['look_count'] = array('ride_offer_id' => $offer['id'], 'look' => '0');
				} 
				$offer['normal_id'] = $offer['id'];
				$offer['id'] = $offerid;// encypt again offerid for security
				$this->data['offer'] = $offer;// load views
				$this->login->general($this->data);// call general load view
				$this->load->view('offers/view_list');//load views
				$this->load->view('include/footer');// load views
			} else {
				show_404('hata');
			}
		} else {
			show_404('hata');
		}
	}
}// END of the Offers Class
/**
 * End of the file offer
 **/