<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

/**
 *
 * OffersAjax Controller
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      İsmail AKBUDAK
 * @link        http://ismailakbudak.com
 *
 */

class OffersAjax extends CI_Controller {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
	}

	/************************************* Puplic methods for ajax *********************************************************/

	/**
	 * AJAX function
	 * Teklif oluşturma işlemi 1.sayfa için triptype 0
	 *
	 * @return JSON output status : success, fail, error
	 **/
	public function createEvent() {

		if ($this->session->userdata('logged_in')) {
			$this->lang->load('offer_controller');// load car_controller language file
			$this->load->helper("offers");
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

}// END of the OffersAjax Class
/**
 * End of the file OffersAjax.php
 **/