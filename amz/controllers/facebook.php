<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Default controller
 *
 * The first controller to be loaded. Serves as the home page of the apps.
 * This controller does return the example rss to the non-user as teaser, hehe.
 * The name amz is aimply abreviation from A-m-a-z-o-n. However it's tentative :P.
 *
 * @package AmazeON(this apps name)
 * @version 0.1
 * @updated 01 March 2013
 * @author Seto El Kahfi<setoelkahfi@gmail.com>
 */
 
class Facebook extends CI_Controller {

	/**
	 * The constructor
	 */
	public function index()
	{
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		//$this->output->enable_profiler(true);
		$this->config->load('facebook');
		$config = array(
					   'appId' => $this->config->item('appId'),
					   'secret' => $this->config->item('secret'),
		);
		$this->load->library('facebook/facebook_api', $config);
		$data['title'] = 'Test Facebook API';
		$data['page'] = 'facebook/index';
		$this->load->view('template',$data);
		 //Usage
		$user = $this->facebook_api->getUser();
		echo 'Access token is '.$this->facebook_api->getAccessToken().'</br>';
        if($user) {
            try {
                $user_info = $this->facebook_api->api('/me');
				echo '<pre>'.htmlspecialchars(print_r($user_info, true)).'</pre>';
				echo "<a href=\"{$this->facebook_api->getLogoutUrl()}\">LogOut</a>";
            } catch(FacebookApiException $e) {
                echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
                $user = null;
            }
        } else {
            echo "<a href=\"{$this->facebook_api->getLoginUrl(array('scope'=>'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'))}\">Login using Facebook</a>";
        }
	}
}

/* End of file amz.php */
/* Location: ./application/controllers/amz.php */