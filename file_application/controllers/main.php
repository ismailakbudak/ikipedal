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
		$this->lang->load('main');
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

		$this->lang->load('offers');

		$offers = $this->offersdb->GetOfersForMain();
		$counts = $this->offersdb->GetOfersForMainCount();
		if (!is_array($offers)) {
			$offers = array('last' => array(), 'today' => array() );
		}

		foreach ($offers as &$value) {
			foreach ($value as &$val) {
				$val['foto'] = photoCheckUser($val);
			}
		}

		$data['offers'] = $offers;
		$data['counts'] = $counts; 

		$this->login->general($data);// call general load view
		$this->load->view('main/index');// load views
		$this->load->view('include/footer');// load views

	}

	/**
	 * Nasıl sayfası yüklenir
	 *
	 * @return HTML view
	 **/
	public function works() {

		$this->login->general();// load views
		$this->load->view('main/works');// load views
		$this->load->view('include/footer');// load views
	}
 

}

/* End of file main.php */
/* Location: ./application/controllers/Main.php */
?>