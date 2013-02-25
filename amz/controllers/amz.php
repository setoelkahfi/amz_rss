<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Default controller
 *
 * The first controller to be loaded. Serves as the home page of the apps.
 */
 
class Amz extends CI_Controller {

	/**
	 * The constructor
	 */
	public function index()
	{
		$this->output->enable_profiler(true);
		$data['title'] = 'Read Amazon (or another) RSS realtime on your e-mail!';
		$data['page'] = 'amz/index';
		$this->load->view('amz/template',$data);
	}
}

/* End of file amz.php */
/* Location: ./application/controllers/amz.php */