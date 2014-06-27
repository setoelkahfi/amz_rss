<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User controller
 *
 * Handle user object. Use to login, logout, register and other task related to users.
 * Restrict only for logged users.
 *
 * @author Seto El Kahfi
 */
class Users extends CI_Controller {

	/** 
	 * The constructor
	 *
	 * Restrcit only for logged user.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_users');
		$this->output->enable_profiler(true);		
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		$this->config->load('facebook');
		$config = array(
					   'appId' => $this->config->item('appId'),
					   'secret' => $this->config->item('secret'),
		);
		$this->load->library('facebook/facebook_api', $config);
	}
	
	/**
	 * Index function
	 *
	 */
	public function index( $id = NULL, $name  = NULL)
	{
		/**
		 * Important!! 
		 * Since we use CI session class, we check the user by his username.
		 */
		if ( ! $this->session->userdata('user_name'))
		{
			$this->session->set_flashdata('msg','<div class="alert alert-error flash">You must login or register first to use this service</div>');
			redirect('/users/login/');
		}
		if (isset($id))
		{
			$data['items'] = $this->m_users->get_users($id);
			if ($data['items']->num_rows() < 1)
			{				
				//show_404('page');
			}
			$data['page'] = 'users/user';
			$this->load->view('template',$data);
			
		}
		else
		{
			$data['title'] = 'Manage Your Data';
			$data['page'] = 'users/index';
			$this->load->view('template',$data);
		}
	}
	
	public function fblogout()
	{
		$this->session->sess_destroy();
        header('Location: /amazon/');
    }
	
    public function fblogin()
	{
        $user = $this->facebook_api->getUser();
		
		echo 'Access token is '.$this->facebook_api->getAccessToken().'</br>';
        if($user){
            try {
                $user_profile = $this->facebook_api->api('/me');
                $params = array('next' => base_url().'users/fblogout');
                $ses_user = array(
					'User'=>$user_profile,
                    'logout' =>$this->facebook_api->getLogoutUrl($params)
                );
                $this->session->set_userdata($ses_user);
				echo '<pre>'.htmlspecialchars(print_r($user_profile, true)).'</pre>';
               // header('Location: '.base_url());
            } catch(FacebookApiException $e){
                error_log($e);
				echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
                $user = NULL;
            }       
        }
		else
		{
			echo 'cant get';
		}
    }
	
	/**
	 * Logout user
	 *
	 * Destroy all session data.
	 */
	public function logout()
	{
		$array = array(
			'user_name' => '',
			'user_id' => '',
			'user_level' => '',
			'user_password' => '',
		);
		$this->session->unset_userdata($array);
		$this->session->set_flashdata('msg','<div class="alert alert-success flash">Youre now log-out!</div>');
		redirect('/');
	}
			
	/**
	 * Get the login form
	 */
	function login()
	{
		if ($this->session->userdata('user_name'))
		{
			redirect('/users/');
		}
		$data['fb_login'] = $this->facebook_api->getLoginUrl(array('scope'=>'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos','redirect_uri' => base_url().'facebook'));
		$data['page'] = 'users/login';
		$this->load->view('template',$data);
	}
	
	/**
	 * Do login
	 */
	function login_do()
	{
		//$this->output->enable_profiler(true);
		// The validation
		$error = array();
		if (empty($_POST['inputEmail'])) 
		{
			$response->error['errEmail'] = "Id Peserta belum disii.";
		} 
		else 
		{
			$user_id = $_POST['inputEmail'];
		}
		if (empty($_POST['inputPassword'])) 
		{
			$response->error['errPassword'] = "Password belum diisi.";
		} 
		else 
		{
			$pass = md5($_POST['inputPassword']);
		}
		//echo "Email $id_peserta </br>";
		//echo "Passs $pass";
		// Do it if there's no error
		if (empty($response->error)) 
		{
			//echo $query;
			$query = $this->m_users->login($user_id, $pass);
			if ($query->num_rows() > 0) 
			{ 
				// Store the session variabel
				$data = $query->row();
				$this->session->set_userdata('user_id', $data->user_id);
				$this->session->set_userdata('user_password', $data->user_password);
				$this->session->set_userdata('user_name', $data->user_name);
				$this->session->set_userdata('user_level', $data->user_level);
				
				// Set the result response
				$response->status = true;
				$response->user_name = $data->user_name;
			} 
			else 
			{ // No
				$response->error['errOther'] = "Password atau e-mail Anda salah. Atau Anda belum mengkonfirmasi e-mail Anda.";
				$response->status = false;
			}
		} 
		else 
		{
			$response->status = false;
		}

		//out put result
		echo json_encode($response);
	}
	
	/**
	 * Form register
	 */
	function register()
	{
		if ($this->session->userdata('user_name'))
		{
			redirect('/users/');
		}
		$data['page'] = 'users/register';
		$this->load->view('template',$data);
	}
	
	/**
	 * Register new user
	 */
	function register_do() 
	{
		// The validation
		$error = array();
		if (empty($_POST['inputName'])) 
		{
			$response->error['errName'] = 'Name required.';
		} 
		else 
		{
			$name = $_POST['inputName'];
		}
		if (empty($_POST['inputEmail'])) 
		{
			$response->error['errEmail'] = 'E-mail required.';
		} 
		else 
		{
			//regular expression for email validation
			if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST['inputEmail'])) {
				$email = $_POST['inputEmail'];
			} else {
				$error['errEmail'] = 'Please use your valid e-mail.';
			}
		}
		if (empty($_POST['inputPassword'])) 
		{
			$response->error['errPassword'] = 'Password required.';
		} 
		else 
		{
			$pass = md5($_POST['inputPassword']);
		}
		if (empty($_POST['inputPasswordRe'])) 
		{
			$response->error['errPasswordRe'] = 'Retype Password.';
		} 
		else 
		{
			$pass = md5($_POST['inputPasswordRe']);
		}
		if ($_POST['inputPassword'] !== $_POST['inputPasswordRe'])
		{
			$response->error['errPasswordMatch'] = 'Password didn\'t match.';
		}
		//echo "Email $id_peserta </br>";
		//echo "Passs $pass";
		// Do it if there's no error
		if (empty($response->error)) 
		{
			// Is the user not confirm his/her email yet?
			$query = "SELECT user_email FROM users
						WHERE user_email = '{$email}'";
			
			$result_query = mysqli_query($dbc,$query);
			// E-mail already registered
			if (mysqli_num_rows($result_query) == 1) 
			{ 
				$response->err['errEmailRegistered'] = 'E-mail already registered, use another one.';
				$response->status = false;
			} 
			else 
			{ // New email
				$activation = md5(uniqid(rand(), true));
				$query = "INSERT INTO users(user_email, user_password, user_name, confirm) 
						VALUES('{$email}','{$pass}','{$name}','{$activation}')";
				//echo $query;
				$result_query = mysqli_query($dbc,$query);
				if ($result_query)
				{
					$response->status = true;
				}
				else
				{
					$response->error['errOther'] = 'Upss, sorry, register failed. Technically error.';
					$response->status = false;
				}
			}
		} 
		else 
		{
			$response->status = false;
		}

		//out put result
		echo json_encode($response);
	}
	
	/**
	 * Ajax load page
	 *
	 * Call from ajax-request at users page. Use for display logs, tracking ids and API keys
	 * Each menu called by ajax request
	 * Each menu group for their CRUD functionality
	 */
	 
	/**
	 * Logs activity
	 *
	 * A read only menu, there's no CRUD activity
	 */
	public function logs()
	{
		echo '<div class="row-fluid">
	<div class="span3">
		<h4>username.</h4>
		<div class="thumbnail well">Container to hold the user photo</div> 
	</div><div class="span3">
		<h4>username.</h4>
		<div class="thumbnail well">Container to hold the user photo</div> 
	</div>
	<div class="span3">
		<h4>username.</h4>
		<div class="thumbnail well">Container to hold the user photo</div> 
	</div>
	<div class="span3">
		<h4>username.</h4>
		<div class="thumbnail well">Container to hold the user photo</div> 
	</div>
</div>';
	}
	
	/**
	 * Tracking Ids Menu Handle
	 *
	 * Crud menu for tracking Ids of the user, including add new, edit, update and delete
	 * All called by ajax request
	 */
	 
	/**
	 * List all tracking Ids
	 */
	public function tracking_ids()
	{
		$query = $this->m_users->get_tracking_id();
		
		$content = '<p class="lead">Tracking Ids<a href="#add-tracking-id" class="btn btn-danger pull-right modal-trigger">Add Tracking Id</a></p>';
		if ($query->num_rows() > 0)
		{
			$content .= '<table class="table"><thead><tr><th>No</th><th>Tracking Id</th><th>Locale</th><th>Action</th></tr></thead><tbody>';
			$i =1;
			foreach ($query->result() as $item)
			{
				$content .= '<tr><td>'.$i.'</td><td>'.$item->tracking_id.'</td><td>'.$item->locale.'</td><td><a  href="#edit-tracking-id-'.$item->id.'" class="modal-trigger"><i class="icon icon-pencil"></i></a>&nbsp;&nbsp;<a href="#delete-tracking-id-'.$item->id.'" class="delete-trigger"><i class="icon icon-remove"></i></a></td></tr>';
				$i++;
			}
			$content .= '</tbody></table>';
		}
		echo $content;
	}
	
	/**
	 * From add new tracking Id
	 */
	public function add_tracking_id()
	{
		$query = $this->m_users->get_locale();
		
		$content = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove"></i></button>
			<h3 id="form-title">Add New Tracking Id</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal add-new" id="save-tracking-id">
					<div class="control-group">
						<label class="control-label" for="inputTrackingId">Tracking Id</label>
						<div class="controls">
							<input type="text" name="inputTrackingId" placeholder="Tracking Id">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputLocale">Locale</label>
						<div class="controls">
							<select name="inputLocale">';
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{
				@$option .= '<option value="'.$item->locale.'">'.$item->country.'</option>';
			}
			$content .= $option;
		}
		$content .= '</select>
						</div>
					</div>
					<p class="ajax-loader">
						<img src="assets/img/ajax-loader-strip.gif">
					</p>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary btn-login">Save</button>
					</div>
				</form>
			</div>';
		echo $content;
	}
	
	/**
	 * From edit new tracking Id
	 */
	public function edit_tracking_id($id)
	{
		$query = $this->m_users->get_tracking_id($id);
		$query2 = $this->m_users->get_locale();
		
		$content = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove"></i></button>
			<h3 id="form-title">Edit Tracking Id</h3>
			</div>
			<div class="modal-body">';
		
		if ($query->num_rows() < 1)
		{
			$content .='Sorry, no record found.';
		}
		else
		{
			$item = $query->row();
			$content .=	'<form class="form-horizontal add-new" id="save-tracking-id">
					<div class="control-group">
						<label class="control-label" for="inputTrackingId">Tracking Id</label>
						<div class="controls">
							<input type="text" name="inputTrackingId" value="'.$item->tracking_id.'">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputLocale">Locale</label>
						<div class="controls">
							<select name="inputLocale">';
			if ($query2->num_rows() > 0)
			{
				foreach ($query2->result() as $item2)
				{
					
					@$option .= ($item->locale == $item2->locale) ? '<option value="'.$item2->locale.'" selected>'.$item2->country.'</option>' : '<option value="'.$item2->locale.'">'.$item2->country.'</option>';
				}
				$content .= $option;
			}
			$content .= '</select>
						</div>
					</div>
					<p class="ajax-loader">
						<img src="assets/img/ajax-loader-strip.gif">
					</p>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary btn-login">Save</button>
					</div>
				</form>';
		}
		$content .='</div>';
		echo $content;
	}
	
	/**
	 * Save new tracking id
	 */	
	public function save_tracking_id()
	{
		$tracking_id = $this->input->post('inputTrackingId');
		$locale = $this->input->post('inputLocale');
		if ($this->m_users->save_tracking_id($tracking_id,$locale))
		{
			$response->status='true';
			$response->msg='Succesfully saved!';
		}
		else
		{			
			$response->status='false';
			$response->msg='Sorry, I don\'t know what are you talkin\' about :(!';
		}
		echo json_encode($response);
	}
	
	/**
	 * Delete tracking id
	 */	
	public function delete_tracking_id()
	{
		$id = $this->input->post('id');
		if ($this->m_users->delete_tracking_id($id))
		{
			$response->status='true';
			$response->msg='Succesfully saved!';
		}
		else
		{			
			$response->status='false';
			$response->msg='Sorry, I don\'t know what are you talkin\' about :(!';
		}
		echo json_encode($response);
	}
	
	/**
	 * API Keys Menu Handle
	 * 
	 * Group of API Keys menu such as, add, list all, save, and edit
	 * All this function loader by ajax request
	 */
	 
	/**
	 * List all api keys that user has
	 */
	public function api_keys()
	{
		$query = $this->m_users->get_api_key();
		$content = '<p class="lead">API Keys<a href="#add-api-key" class="btn btn-danger pull-right modal-trigger">Add Key</a></p>';
		if ($query->num_rows() > 0)
		{
			$content .= '<table class="table"><thead><tr><th>No</th><th>Public Key</th><th>Private Key</th><th>Action</th></tr></thead><tbody>';
			$i =1;
			foreach ($query->result() as $item)
			{
				$content .= '<tr><td>'.$i.'</td><td>'.$item->public_key.'</td><td>'.$item->private_key.'</td><td><a  href="#edit-api-key-'.$item->id.'" class="modal-trigger"><i class="icon icon-pencil"></i></a>&nbsp;&nbsp;<a href="#delete-api-key-'.$item->id.'" class="delete-trigger"><i class="icon icon-remove"></i></a></td></tr>';
				$i++;
			}
			$content .= '</tbody></table>';
		}
		echo $content;
	}
	/**
	 * Form to add new API Keys
	 */
	public function add_api_key()
	{
		$content = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove"></i></button>
			<h3 id="form-title">Add New API Key</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal add-new" id="save-api-key">
					<div class="control-group">
						<label class="control-label" for="inputPublicKey">Public Key</label>
						<div class="controls">
							<input type="text" name="inputPublicKey" placeholder="Public key">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputPrivateKey">Private Key</label>
						<div class="controls">
							<input type="text" name="inputPrivateKey" placeholder="Private key" class="input-block-level">
						</div>
					</div>
					<p class="ajax-loader">
						<img src="assets/img/ajax-loader-60x60.gif" id="ajax-loader-login" >
					</p>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary btn-login">Save</button>
					</div>
				</form>
			</div>';
		echo $content;
	}
	
	/**
	 * Form to edit new API Keys
	 */
	public function edit_api_key()
	{
		$content = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon icon-remove"></i></button>
			<h3 id="form-title">Edit API Key</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal add-new" id="save-api-key">
					<div class="control-group">
						<label class="control-label" for="inputPublicKey">Public Key</label>
						<div class="controls">
							<input type="text" name="inputPublicKey" placeholder="Public key">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputPrivateKey">Private Key</label>
						<div class="controls">
							<input type="text" name="inputPrivateKey" placeholder="Private key" class="input-block-level">
						</div>
					</div>
					<p class="ajax-loader">
						<img src="assets/img/ajax-loader-60x60.gif" id="ajax-loader-login" >
					</p>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary btn-login">Save</button>
					</div>
				</form>
			</div>';
		echo $content;
	}
	
	/**
	 * Save new api key
	 */	
	public function save_api_key()
	{
		$public_key = $this->input->post('inputPublicKey');
		$private_key = $this->input->post('inputPrivateKey');
		if ($this->m_users->save_api_key($public_key,$private_key))
		{
			$response->status='true';
			$response->msg='New API Keys Succesfully saved!';
		}
		else
		{			
			$response->status='false';
			$response->msg='Sorry, I don\'t know what are you talkin\' about :(!';
		}
		echo json_encode($response);
	}
	
	/**
	 * Delete api key
	 */	
	public function delete_api_key()
	{
		$id = $this->input->post('id');
		if ($this->m_users->delete_api_key($id))
		{
			$response->status='true';
			$response->msg='New API Keys Succesfully saved!';
		}
		else
		{			
			$response->status='false';
			$response->msg='Sorry, I don\'t know what are you talkin\' about :(!';
		}
		echo json_encode($response);
	}
}

/* End of file users.php */
/* Location: ./amz/controller/users.php */