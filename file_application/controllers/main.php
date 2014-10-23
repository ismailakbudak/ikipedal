<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

/**
 *
 * Main Controller
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      İsmail AKBUDAK
 * @link        http://ismailakbudak.com
 *
 */
class Main extends CI_Controller {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Anasayfa yükleniyor
	 *
	 * @return HTML view
	 **/
	public function index() {

		// If there is no language in the url default tr do it
		if (strcmp($this->uri->segment(1), "") == 0) {
			redirect("tr/main");
		}

		$this->load->helper('search');
		$this->load->model('offersdb');// load offers model
		$this->load->model('searched');// load searched model

		$this->lang->load('main');
		$this->lang->load('offerinfo');

		$offers = $this->offersdb->GetOfersForMain();
		$result = $this->searched->GetMost();
		if (!is_array($offers)) {
			$offers = array('last' => array(), 'today' => array(), 'best' => array());
		}

		if (!is_array($result)) {
			$mostSearched = array();
			$mostCreated = array();
		} else {
			$mostSearched = $result['mostSearched'];
			$mostCreated = $result['mostCreated'];
		}

		foreach ($offers as &$value) {
			foreach ($value as &$val) {
				$val['foto'] = photoCheckUser($val);
			}
		}

		$data['offers'] = $offers;
		$data['mostSearched'] = $mostSearched;
		$data['mostCreated'] = $mostCreated;

		$this->login->general($data);// call general load view
		$this->load->view('main/main');// load views
		$this->load->view('include/footer');// load views

	}

	/**
	 * Teklif verme sayfasının ilk bölümü
	 *
	 * @return HTML view
	 **/
	public function offerRide() {
		$this->load->model('event_types');// load offers model
		$types = $this->event_types->Get();
		if (is_array($types)) {
			$this->lang->load('offer');
			$this->login->general();// call general load view
			$data['event_types'] = $types;
			$this->load->view('main/offerRide', $data);// load view
			$this->load->view('include/footer');// load view
		} else {
			show_404();
		}
	}

	/**
	 * Nasıl sayfası yüklenir
	 *
	 * @return HTML view
	 **/
	public function works() {
		$this->lang->load('main');
		$this->login->general();// load views
		$this->load->view('main/works');// load views
		$this->load->view('include/footer');// load views
	}

	/**
	 *  Teklif arama sayfası yüklenir
	 *
	 *  @return HTML view
	 **/
	public function offers() {
		$this->lang->load('main');
		$this->login->general();// load views
		$this->load->view('main/search');// load views
		$this->load->view('include/footer');// load views
	}

}

/* End of file main.php */
/* Location: ./application/controllers/Main.php */
?>