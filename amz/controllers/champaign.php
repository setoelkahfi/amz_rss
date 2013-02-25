<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The champaign user control panel
 *
 * User control panel, use for manage their subscription.
 */
 
class Champaign extends CI_Controller {

	/**
	 * The constructor
	 *
	 * Restrict only for logged-user. Otherwise throw them to the home page
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_champaign');
	}
	
	/**
	 *
	 *
	 */
	public function index()
	{
		$data['items'] = $this->m_champaign->get_champaign();
		$data['title'] = 'Champaign';
		$data['page'] = 'champaign/index';
		$this->load->view('champaign/template',$data);
	}
	
	/**
	 *
	 *
	 */
	public function add()
	{
		$data['items'] = $this->m_champaign->get_search_index_value();
		$data['title'] = 'Champaign | Add';
		$data['page'] = 'champaign/campaign_add';
		$this->load->view('champaign/template',$data);
	}
	
	/**
	 * Save new rss link and other information related
	 */
	function rss_save()
	{
		session_start();

		// Must login
		if ( ! isset($_SESSION['user_name']))
		{
			$response->status = false;
			$response->status_text = '<div class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">&times;</button>You must login or register first to use this service</div>';
			echo json_encode($response);
			exit;
		}

		require_once('../config.php');
		//require_once('../lib/simplepie.php');
		//echo $_POST['inputRss'];
		if (empty($_POST['inputRss']))
		{
			$response->error['errRss'] = $_POST['inputRss'];
		}
		else
		{
			$rss_link = $_POST['inputRss'];
		}
		if (empty($_POST['inputEmail']))
		{
			$response->error['errMail'] = $_POST['inputEmail'];
		}
		else
		{
			$rss_email = $_POST['inputEmail'];
		}

		// process onlly if there's no error
		if ( ! @$response->error)
		{
			// Check if there's same item in table 
			$query 	= mysqli_query($dbc, "SELECT list_id FROM rss_lists WHERE list_link='{$rss_link}'");
			$row 	= mysqli_num_rows($query);
			// If row empty, save to the table
			if( $row < 1)
			{
				// Insert information to the table
				$query 	= mysqli_query($dbc, "INSERT INTO rss_lists VALUES('','{$_SESSION['user_id']}','{$rss_link}','{$rss_email}')");
				$row 	= mysqli_num_rows($query);
			} 
			else 
			{
				$response->status = 'Rss already subscribed';
			}
		}
		echo json_encode($response);
	
	}
	/* backup original rss-feed
	// Check Row
			$query = mysql_query("SELECT * FROM rssgoemail WHERE guid='$guid'");
			$row = mysql_num_rows($query);
		
			// If row empty send email and happy blogging
			if( $row < 1){
				
				$mail = $desc."<br /><br /><a href=\"".$link."\" rel=\"nofollow\">Read More</a>";
				// To send HTML mail, the Content-type header must be set
				$headers  = "MIME-Version: 1.0 \r\n";
							$headers .= "X-Mailer: PHP \r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: support@example.com\r\n";
				$headers .= "Reply-to: me@gmail.com\r\n";
				$send = @mail($email.', setoelkahfi1.nano@blogger.com', $title, $mail, $headers);
				echo $send ? "Send ".$title."<br />" : "Gagal $email ";
				$desc = mysql_real_escape_string(htmlentities($desc));
				//echo "$desc </br>";
				$sql = "INSERT INTO rssgoemail(title,guid,description) VALUES ('$title','$guid','$desc')";			
				//echo $sql;
				if(mysql_query($sql)) echo "Insert berhasil $title</br>";
				else continue;
				
			}
			*/
}

/* End of file champaign.php */
/* File location: ./amz/controller/champaign.php */