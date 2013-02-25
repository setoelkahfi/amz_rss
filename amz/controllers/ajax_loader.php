<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Ajax loader file
 *
 * Serve as ajax request controller, use in all apps. This including home page which 
 * fetch the rss to be shown at the home page.
 *
 * @package AmazeON
 * @author Seto El Kahfi
 */
class Ajax_loader extends CI_Controller {

	/**
	 * The constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Get the login form
	 */
	function login()
	{
		$this->load->view('user/login');
	}
	
	/**
	 * Do login
	 */
	function login_do()
	{
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
			// Is the user not confirm his/her email yet?
			$query = "SELECT * FROM users
						WHERE user_email = '{$user_id}'
						AND user_password = '{$pass}'
						AND confirm IS NULL";
			//echo $query;
			$result_query = mysqli_query($dbc,$query);
			if (mysqli_num_rows($result_query) == 1) 
			{ 
				// Yes, they already confirmed
				// Store the session variabel
				$data = mysqli_fetch_array($result_query);
				$_SESSION['user_id'] = $data['user_id'];
				$_SESSION['user_password'] = $data['user_password'];
				$_SESSION['user_name'] = $data['user_name'];
				$response->status = true;
				$response->user_name = $_SESSION['user_name'];
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
		$this->load->view('user/register');
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
	 * Show rss result at home page
	 */
	public function rss_show()
	{
		$url = 'http://www.amazon.com/gp/rss/bestsellers/automotive/15857511/ref=zg_bs_15857511_rsslink';//$this->input->post('inputRss');
		//echo 'the uel is ' . $url;
		// Load simplepie
		$this->load->library('simplepie');
			
		$this->simplepie->set_feed_url($url);
			
		$this->simplepie->enable_cache('false');
		$this->simplepie->set_cache_location('cache');
		$cachetime = (intval(120) / 60); //convert from seconds to minutes
		$this->simplepie->set_cache_duration($cachetime);
			
		// Init this->simplepie
		$this->simplepie->init();
		// Make sure the page is being served with the UTF-8 headers.
		$this->simplepie->handle_content_type();
		$items = $this->simplepie->get_items();
		
		if ($items)
		{
			foreach($items as $item)
			{
				
				$title = substr(strstr($item->get_title()," "), 1);
				//echo $title; 		
				$guid = md5($item->get_id());
				$link = $item->get_link();
				$desc = '<div class="chunk">';
				// If the item has a permalink back to the original post (which 99% of them do), link the item's title to it. -->
				$desc .= '<h4>';
				if ($item->get_permalink()) $desc .= '<a href="' . $item->get_permalink() . '">'; 
				$desc .= $title; 
				if ($item->get_permalink()) $desc .= '</a>';
				$desc .= '&nbsp;<span class="footnote">';
				$desc .= $item->get_date('j M Y, g:i a'); 
				$desc .= '</span></h4>';

				// Display the item's primary content. -->
				$desc .= $item->get_content(); 
			
				// Check for enclosures.  If an item has any, set the first one to the $enclosure variable.
				if ($enclosure = $item->get_enclosure(0))
				{
					// Use the embed() method to embed the enclosure into the page inline.
					$desc .= '<div align="center">';
					$desc .= '<p>' . $enclosure->embed(array(
									'audio' => './for_the_demo/place_audio.png',
									'video' => './for_the_demo/place_video.png',
									'mediaplayer' => './for_the_demo/mediaplayer.swf',
									'altclass' => 'download'
								)) . '</p>';

					if ($enclosure->get_link() && $enclosure->get_type())
					{
						$desc .= '<p class="footnote" align="center">(' . $enclosure->get_type();
						if ($enclosure->get_size())
						{
							$desc .= '; ' . $enclosure->get_size() . ' MB';
						}
						$desc .= ')</p>';
					}
					if ($enclosure->get_thumbnail())
					{
						$desc .= '<div><img src="' . $enclosure->get_thumbnail() . '" alt="" /></div>';
					}
					$desc .= '</div>';
				}
				$desc .= '</div>';
			}
			$response->rss = $desc;		
			$response->result = true;
			$response->msg = 'Success!';
		}
		else
		{
			$response->result=false;
			$response->msg = 'Invalid rss link!';
		}
		
		 /* Example usage of the Amazon Product Advertising API */
		// Load the library 
		$this->load->library('amazon_api');
		$title = explode(' ',$title);
		try
		{
			$result = $this->amazon_api->searchProducts($title[0], 'DVD', 'TITLE');
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
    
		if ($result)
		{
			foreach ($result->Items->Item as $item) {
				@$product .=  "<br><br>Title: <a href=\"".$item->ItemLinks->ItemLink[0]->URL."?tag=".$this->amazon_api->associate_tag."\">{$item->ItemAttributes->Title}</a><br>"; 
				$product .= "<br>Sales Rank : {$item->SalesRank}"; 
				
				$product .= @$item->EditorialReviews->EditorialReview->Content ? "<br>Product Description : {$item->EditorialReviews->EditorialReview->Content}" : "";
				$product .= "<br>ASIN : {$item->ASIN}<br>";
				$product .= "<br><img src=\"" . $item->MediumImage->URL . "\" /><br><br>";
				if ($item->CustomerReviews->HasReviews == 'true') {
						$product .= "{$item->CustomerReviews->HasReviews}";
						$product .= "Customer review : <iframe src=\"".$item->CustomerReviews->IFrameURL."\" frameborder=\"0\" width=\"100%\" height=\"100%\"></iframe>";
				}
			}
			$response->product =  $product;
		}
		echo json_encode($response);
	}
}

/* End of file ajax_loader.php */
/* Location: ./application/controllers/ajax_loader.php */