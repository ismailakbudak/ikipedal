<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}
/**
 *
 * Offer Controller
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      İsmail AKBUDAK
 * @link        http://ismailakbudak.com
 *
 */
class Offer extends CI_Controller {
	/**
	 *   Global variable
	 **/
	public $userid, $data;
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->data = $this->login->loginKontrol();// check user login or not if not redirect main
		$this->load->helper("offer");// load helper file for action
		$this->userid = $this->encrypt->decode($this->session->userdata('userid'));// set global variable
		$this->data['active'] = '#offers';// active profile menu
		$this->load->model('offersdb');// load offersdb model for database action
		$this->load->model('event_paths');// load event_paths model for database action
		$this->load->model('look_at');// load look_at model for database action
		$this->load->model('rutin_trips');// load rutin_trips model for database action
		$this->lang->load('offers');// load offer_controller language file
	}
	/*****  for Views method
	=============================================*/
	/**
	 *  Kullanıcının aktif olan tekliflerini listeler
	 *
	 *  @return HTML view
	 **/
	public function index() {
		$this->data['active_side'] = '#upcoming';// active sidebar menu
		$offers = $this->offersdb->GetUserOffer($this->userid);// get users up-date offers   $user_id, $numrows, $start
		if (is_array($offers)) {
			foreach ($offers as &$value) {
				//$value['event_paths'] = $this->event_paths->GetOfferWays($value['id']);// get offer waypoints
				$look_count = $this->look_at->GetLookCount($value['id']);// get looked people count for this offerid
				if (count($look_count) > 0) {
					$value['look_count'] = $look_count;
				} else {
					$value['look_count'] = array('ride_offer_id' => $value['id'], 'look' => '0');
				}
				$value['normal_id'] = $value['id'];
				$value['id'] = urlencode(base64_encode($value['id']));// encypt again offerid for security
			}
			$this->data['offers'] = $offers;// load views
			$viewContent = 'indexOffer';// load views
			$this->loadContent($this->data, $viewContent);// load views
		} else {
			show_404('hata');
		}
	}
	/**
	 *  Kullanıcının aktif olmayan tekliflerini listeler
	 *
	 *  @return HTML view
	 **/
	public function passed() {
		$this->data['active_side'] = '#passed';// active sidebar menu
		$offers = $this->offersdb->GetUserOfferOutofDate($this->userid);// get users up-date offers $user_id, $numrows, $start
		if (is_array($offers)) {
			foreach ($offers as &$value) {
				$value['event_paths'] = $this->event_paths->GetOfferWays($value['id']);// get offer waypoints
				$look_count = $this->look_at->GetLookCount($value['id']);// get looked people count for this offerid
				if (count($look_count) > 0) {
					$value['look_count'] = $look_count;
				} else {
					$value['look_count'] = array('ride_offer_id' => $value['id'], 'look' => '0');
				}
				if (strcmp($value['trip_type'], "1") == 0) {// if there is get offer trip days
					$rutin_trip = $this->rutin_trips->GetOfferDays($value['id']);// get trip days for this offerid
					if (count($rutin_trip) > 0) {
						$value['rutin_trip'] = $rutin_trip;
					} else {
						$value['rutin_trip'] = array(0 => array('id' => 0, "is_return" => "-1", "day" => ""));
					}
				}
				$value['normal_id'] = $value['id'];
				$value['id'] = urlencode(base64_encode($value['id']));// encypt again offerid for security
			}
			$this->data['offers'] = $offers;// load views
			$viewContent = 'indexOffer';// load views
			$this->loadContent($this->data, $viewContent);// load views
		} else {
			show_404('hata');
		}
	}
	/**
	 *  Teklif güncelleme sayfası
	 *
	 *  @param  $offerid şifrelenmiş teklif id
	 *  @return HTML view
	 **/
	public function update($event_id) {
		if (!isset($event_id)) {
			show_404();
		}

		$event_id = base64_decode(urldecode($event_id));// decode event_id
		$event = $this->offersdb->GetOffer($event_id);// get offer
		if (is_array($event) && count($event) > 0) {
			$this->load->model('event_types');// load offers model
			$types = $this->event_types->Get();
			if ($event['user_id'] == $this->userid && is_array($types)) {
				$event['event_id_code'] = $this->encrypt->encode($event['id']);
				$data['offer'] = $event;// send userdata to view
				$data['event_types'] = $types;
				$this->login->general($data);// load views
				$this->load->view('offer/offerUpdate');// load views
				$this->load->view('include/footer');// load views
			} else {
				show_404('hata');
			}
		} else {
			show_404('hata');
		}
	}

	/**
	 * AJAX function
	 * Teklif oluşturma işlemi 1.sayfa için triptype 0
	 *
	 * @return JSON output status : success, fail, error
	 **/
	public function updateAction() {
		$event_id = $this->input->post('event_id', TRUE);
		if (isset($event_id) && strcmp('', trim($event_id)) != 0) {
			$eventdata = $this->offersdb->GetOffer($event_id);// get offer
			if (is_array($eventdata) && count($eventdata) > 0 && $eventdata['user_id'] == $this->userid) {
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
						$value['event_id'] = $event_id;
					}
					$this->offersdb->updateOfferAll($event_id, $event, $ways_offer);

					if ($event_id) {// offer has been saved succesfully unset session data
						$origin = $event['origin'];
						$destination = $event['destination'];
						$origin = explode(',', $origin);
						$origin = $origin[0];
						$destination = explode(',', $destination);
						$destination = $destination[0];
						$name = urlCreate($this->lang->lang(), $origin, $destination, $event_id);
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
				$status = "notEventId";
				$error['message'] = lang('oc.event_id');
				$name = "null";
			}
		} else {
			$status = "notEventId";
			$error['message'] = lang('oc.event_id');
			$name = "null";
		}
		$result = array('status' => $status, // JSON output
			'message' => $error['message'],
			'path' => $name);
		echo json_encode($result);// JSON output
	}

	/***********************************  For ajax method ********************************************************************/
	/**
	 *  Kullanıcıya mesaj gönder
	 *
	 *
	 *  @return JSON output status: success, fail, error
	 **/
	function contactDriver() {
		$this->form->check(lang('oc.user_id'), 'user_id', 'required|xss_clean');// check post data
		$this->form->check(lang('oc.message'), 'message', 'required|min_length[20]|max_length[400]|xss_clean');// check post data
		$this->form->check(lang('oc.id'), 'offer_id', 'required|xss_clean');// check post data
		if ($this->form->get_result()) {
			$sender_user_id = $this->userid;// session user_id
			$receiver_user_id = $this->encrypt->decode($this->input->post('user_id', TRUE));// decode receiver user id
			$offer_id = $this->input->post('offer_id', TRUE);// decode receiver user id

			if ($sender_user_id != 0 && $receiver_user_id != 0) {
				if (strcmp($receiver_user_id, $sender_user_id) != 0) {// compare user ids is it same
					$this->load->model("block_user");
					$result = $this->block_user->isthereblock($receiver_user_id, $sender_user_id);// get is there a blocked user
					if (count($result) == 0) {
						$this->load->model("messages");// create message model
						$message = array('event_id' => $offer_id,
							'user_id' => $sender_user_id,
							'received_user_id' => $receiver_user_id,
							'readed_sender' => 1,
							'message' => $this->input->post('message', TRUE));
						$result = $this->messages->add($message);// add message to database
						$status = ($result) ? "success" : "fail";// change status

						$text = ($result) ? lang("oc.send-success") : lang("oc.send-fail");// set message
						//$this->sendEmail($sender_user_id, $receiver_user_id, $offer_id);// send email to receiver
					} else {
						$status = "mistake";
						$text = lang("oc.block");
					}
				} else {
					$status = "mistake";
					$text = lang("oc.send-error");
				}
			} else {
				$status = "mistake";
				$text = lang("oc.try-again");
			}
		} else {
			$status = "error";
		}
		$error = $this->form->get_error();//  if there is error get it from Form validation class
		$result = array('status' => $status, // JSON output
			'message' => $error['message'],
			'text' => (isset($text)) ? $text : "");
		echo json_encode($result);// JSON output
	}
	/**
	 *  Kullanıcıya mesaj gönderme işlemi ile birlikte kullanıcıya mail gönderme işlemi
	 *
	 *  @param $sender_userid
	 *  @param $receiver_user_id
	 *  @param $offer_id
	 *  @return JSON output status: success, fail, error
	 **/
	private function sendEmail($sender_userid, $receiver_user_id, $offer_id) {
		$this->load->model('users');
		$this->load->model('notifications');
		$sender = $this->users->GetUser($sender_userid);// get user information
		$receiver = $this->users->GetUser($receiver_user_id);// get user information
		$offer = $this->offersdb->GetOffer($offer_id);// get offer
		$notification = $this->notifications->GetNotification($receiver_user_id);// get user _notifiactions
		if ($sender && $receiver && $offer && $notification) {
			if (strcmp($notification['new_message'], "1") == 0) {
				$this->load->helper('email');
				$this->lang->load('email_controller');// email language
				$this->load->library('email');// load library for email
				$recipient = $receiver['email'];// receiver adress
				$subject = lang('me.private-message');// subject from language file
				$message = mailSendMessageUser($receiver, $sender, $offer, $this->lang->lang());
				$this->email->set_newline("\r\n");
				$this->email->from('hep@hepgezelim.com', lang('e.name'));// sender name
				$this->email->to($recipient);// receiver
				$this->email->subject($subject);// subject
				$this->email->message($message);// message
				if ($this->email->send())// send email
				{return true;
				} else {
					return false;
				}
			}
		} else {
			return FALSE;
		}
	}
	/************************************* Puplic methods for ajax *********************************************************/

	/**
	 *  AJAX function
	 *  Teklif silme işlemi
	 *
	 *  @param  $id
	 *  @return JSON output status : success, fail, error
	 *
	 **/
	public function deleteOffer() {
		$this->form->check(lang('oc.id'), 'offer_id', 'required|xss_clean');// check post data
		if ($this->form->get_result()) {
			$offer_id = base64_decode(urldecode($this->input->post('offer_id', TRUE)));// post offerid
			$offer = $this->offersdb->GetOffer($offer_id);// get offer
			if (is_array($offer) && count($offer) > 0) {
				if ($offer['user_id'] == $this->userid) {
					// Delete çıkarıldı
					//$status = ($this->offersdb->deleteOffer($offer_id) == TRUE ) ? 'success' : "fail";   // delete offer all information
					$offer = array('is_active' => 0);
					$result = $this->offersdb->UpdateOffer($offer_id, $offer);// update  offer rreturn date info
					$status = ($result ? 'success' : 'fail');
				} else {
					$status = "fail";
					$text = lang('permission');
				}
			} else {
				$status = "fail";
			}
		} else {
			$status = "error";
		}
		$error = $this->form->get_error();//  if there is error get it from Form validation class
		$result = array('status' => $status,
			'text' => isset($text) ? $text : lang('fail'),
			'message' => $error['message']);// JSON output
		echo json_encode($result);// JSON output
	}
	/*********************************** Private Functions for using methods*******************************************************/
	/**
	 * Sayfa yükleme metodu
	 *
	 * @param  $data sayfa içeriği için bilgiler
	 * @param  $content  yüklenecek olan içerik sayfası
	 * @return HTML view
	 **/
	private function loadContent($data = array(), $viewContent) {
		$this->login->loadViewHead($data);
		$this->load->view('offer/offerHead');
		$this->load->view('offer/' . $viewContent);
		$this->load->view('offer/offerFoot');
		$this->login->loadViewHeadFoot();
	}
}// END of the Offer Class
/**
 * End of the file offer
 **/