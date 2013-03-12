<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The campaign user control panel
 *
 * User control panel, use for manage their subscription.
 * Actually this is for Amazon rss fedd which integrated with blogspot for posting automatically with email posting
 * facility from blogspot.
 * 
 * @version 0.1
 * @package AmazeON(for now this is the name of the apps)
 * @updated 01 March 2013
 */
 
class Campaign_blogger extends CI_Controller {

	/**
	 * The constructor
	 *
	 * Restrict only for logged-user. Otherwise throw them to the login page.
	 * Load the m_campaign model class.
	 */
	function __construct()
	{
		parent::__construct();
		/**
		 * Important!! 
		 * Since we use CI session class, we check the user by his username.
		 */
		if ( ! $this->session->userdata('user_name'))
		{
			$this->session->set_flashdata('msg','<div class="alert alert-error flash">You must login or register first to use this service</div>');
			redirect('/users/login/');
		}
		$this->load->model('m_campaign');
	}
	
	/**
	 * Index function.
	 *
	 * Show the list of user's campaign.
	 */
	public function index()
	{
		//$this->output->enable_profiler(true);
		$data['items'] = $this->m_campaign->get_campaign();
		$data['title'] = 'Campaign';
		$data['page'] = 'campaign/index';
		$this->load->view('template',$data);
	}
	
	/**
	 * Get search index.
	 *
	 * Get search index value of Amazon store by locale. 
	 * This use for dropdown input for search index section. This called by ajax request.
	 *
	 * @param string locale store Amazon
	 * @return JSON ajax response
	 */
	public function get_search_index($locale)
	{
		$query = $this->m_campaign->get_search_index($locale);
		foreach ($query->result() as $item)
		{
			$response[] = $item->name;
		}
		echo json_encode($response);
	}
	
	/**
	 * Get tracking id.
	 *
	 * Get tracking id of user's affilitae program at Amazon.. 
	 * This use for dropdown input for tracking id section. This called by ajax request.
	 *
	 * @param string locale store Amazon
	 * @return JSON ajax response
	 */
	public function get_tracking_id($locale)
	{
		$query = $this->m_campaign->get_tracking_id($locale);
		foreach ($query->result() as $item)
		{
			$response[] = $item->tracking_id;
		}
		echo json_encode($response);
	}
	
	/**
	 * Get detail campaign
	 */
	public function detail($id)
	{
		$query = $this->m_campaign->get_campaign($id);
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{
				//  `id` ,  `blog_title` ,  `blog_url` ,  `user_id` ,  `link` ,  `locale` ,  `category` ,  `tracking_id` ,  `public_key` ,  `private_key` ,  `email` ,  `status` 
				$response->data['title'] = $item->blog_title;
				$response->data['url'] = $item->blog_url;
				$response->data['link'] = $item->link;
				$response->data['locale'] = $item->locale;
				$response->data['category'] = $item->category;
				$response->data['tracking_id'] = $item->tracking_id;
				$response->data['public_key'] = $item->public_key;
				$response->data['private_key'] = $item->private_key;
				$response->data['email'] = $item->email;
				$response->data['status'] = $item->status;
			}
			$response->status = true;
		}
		else 
		{			
			$response->status = false;
		}
		echo json_encode($response);
	}
	
	/**
	 * Update campaign
	 */
	public function update($id,$status = null)
	{
		if ($status==null)
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('blog-title', 'Blog Title', 'required');
			$this->form_validation->set_rules('blog-url', 'Blog URL', 'required');
			$this->form_validation->set_rules('rss', 'RSS', 'required');
			$this->form_validation->set_rules('locale', 'Country', 'required');
			$this->form_validation->set_rules('tracking-id', 'Tracking ID', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, please filling the required field!</div>');
				redirect('campaign/edit/'.$id);
			}
			else
			{
				$blog_title = $this->input->post('blog-title');
				$blog_url = $this->input->post('blog-url');
				$rss = $this->input->post('rss');
				$locale = $this->input->post('locale');
				$category = $this->input->post('category');
				$tracking_id = $this->input->post('tracking-id');
				$public_key = $this->input->post('public-key');
				$private_key = $this->input->post('private-key');
				$email = $this->input->post('email');
				
				// Save the campaign data
				$status = $this->m_campaign->update($id, $blog_title, $blog_url, $rss, $locale, $category, $tracking_id, $public_key, $private_key, $email) ? 'true' : 'false';
				$msg = ($status) ? '<div class="alert alert-success flash">Successfully saved!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
							
				$this->session->set_flashdata('msg', $msg);
				redirect('campaign/');
			}
		}
		else //just update status
		{
			if ($this->m_campaign->update_status($id,$status))
			{
				$response->status = true;
				$response->status_new = ($status == '1') ? '0' : '1';
			}
			else
			{
				$response->status = false;
			}
		}
		echo json_encode($response);
	}
	
	/**
	 * Add new campaign form.
	 *
	 * Show add new campaign form. List all required field to the page.
	 */
	public function add()
	{
		$data['items'] = $this->m_campaign->get_locale();
		$data['api_keys'] = $this->m_campaign->get_api_key();
		$data['title'] = 'Campaign | Add';
		$data['page'] = 'campaign/campaign_add';
		$this->load->view('template',$data);
	}
	
	/**
	 * Save new campaign.
	 * 
	 * Save new campaign value which submitted. User form validation class to validate input data.
	 * All field is required!
	 */
	function save()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('blog-title', 'Blog Title', 'required');
		$this->form_validation->set_rules('blog-url', 'Blog URL', 'required');
		$this->form_validation->set_rules('rss', 'RSS', 'required');
		$this->form_validation->set_rules('locale', 'Country', 'required');
		$this->form_validation->set_rules('tracking-id', 'Tracking ID', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, please filling the required field!</div>');
			redirect('campaign/add');
		}
		else
		{
			$blog_title = $this->input->post('blog-title');
			$blog_url = $this->input->post('blog-url');
			$rss = $this->input->post('rss');
			$locale = $this->input->post('locale');
			$category = $this->input->post('category');
			$tracking_id = $this->input->post('tracking-id');
			$public_key = $this->input->post('public-key');
			$private_key = $this->input->post('private-key');
			$email = $this->input->post('email');
			
			// Save the campaign data
			$status = $this->m_campaign->save($blog_title, $blog_url, $rss, $locale, $category, $tracking_id, $public_key, $private_key, $email) ? 'true' : 'false';
			$msg = ($status) ? '<div class="alert alert-success flash">Successfully saved!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
						
			$this->session->set_flashdata('msg', $msg);
			redirect('campaign/');
		}	
	}
	
	/**
	 * Form edit.
	 *
	 * Show campaign edit form. populate data from campaign id parameter and populate to the appropriate field.
	 *
	 * @param int campaign id
	 */
	public function edit($id)
	{
		//$this->output->enable_profiler(true);
		if ( ! $id)
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
			redirect('champaign/edit/');
		}
		
		$data['countries'] = $this->m_campaign->get_locale();
		$data['api_keys'] = $this->m_campaign->get_api_key();
		$data['items'] = $this->m_campaign->get_campaign($id);
		$data['title'] = 'Campaign -> Edit';
		$data['page'] = 'campaign/campaign_edit';
		$this->load->view('template',$data);
	}
	
	/**
	 * Delete campaign
	 *
	 * @param int campaign id
	 */
	public function delete($id)
	{
		$this->output->enable_profiler(true);
		if ( ! $id)
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
			redirect('champaign/');
		}
		// Delete the campaign data
		$status = $this->m_campaign->delete($id) ? 'true' : 'false';
		$msg = ($status) ? '<div class="alert alert-success flash">Successfully deleted!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
						
		//$this->session->set_flashdata('msg', $msg);
		redirect('campaign/');
	}
	
	/**
	 * Cronjob function
	 *
	 * Function to execute by UNIX cronjob. List all campaign from database that has active status, 
	 * then execute to get the best-seller Amazon product by rss link. 
	 * Search with Amazon_api_class by it's title, then explode the title to get another result. Build the prototye html
	 * to send to the blogspot email.
	 */
	public function cron()
	{		
		// Load the library 
		$this->load->library('amazon_api');
		$query = $this->m_campaign->get_campaign_cron();
		if ($query->num_rows() > 0)
		{
			
			foreach($query->result() as $data)
			{
				$query2 = $this->m_campaign->get_locale($data->locale);
				$locale = $query2->row();
				//echo "Domain adalah".$locale->domain."<br>";
				$url = $data->link.'&tag='.$data->tracking_id;
				// Load simplepie
				$this->load->library('simplepie');
				//echo $url;
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
					//echo 'Title RSS '.$this->simplepie->get_title().'<br>';
					//echo 'Deskripsi '.$this->simplepie->get_description().'<br>';
					foreach($items as $item)
					{
						
						$guid = md5($item->get_id());
						//echo 'Guidnya adalah '.$guid.'<br/>';
												
						$title = substr(strstr($item->get_title(),' '), 1);
						$_title = $title;
						$link = $item->get_link();
						$desc = '<div class="content">';
						// If the item has a permalink back to the original post (which 99% of them do), link the item's title to it. -->
						$desc .= '<h1>';
						if ($item->get_permalink()) $desc .= '<a href="' . $item->get_permalink() . '">'; 
						$desc .= $title; 
						if ($item->get_permalink()) $desc .= '</a>';
						$desc .= '</h1>';
						$desc .= '<p style="border: 2px solid red; padding: 5px;">Note: Product prices and availability were accurate at <b>'.$item->get_date('j M Y, g:i a').'</b> or at the time this post was posted but are subject to change.</p>';

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
						
						//echo $desc ;
						// Ceck if the products already post
						$query_check = $this->m_campaign->get_item_status($guid,$data->id);
						if ($query_check->num_rows() < 1)
						{
							$this->m_campaign->add_item_status($guid,$data->id);
							$this->amazon_api->set($locale->domain,$data->tracking_id,$data->public_key,$data->private_key);
							
							$result = $this->amazon_api->searchProducts($title, $data->category, 'TITLE');
							
							if ( ! $result) // if best seller produk fail to get detail, search with another keyword
							{			
								$title = explode(' ',$title); // break title to get the keyword
								$length = count($title)-1;
								do
								{						
									$length--;
									//echo $panjang;
									for ($i = 0; $i <= $length; $i++)
									{
										@$keyword .= ($i == $length) ? $title[$i] : $title[$i].' ';
									}
									//echo $keyword.'<br>';
									
									$result = $this->amazon_api->searchProducts($keyword, $data->category, 'TITLE');
									$title = array(); // reset title array of keyword
									$title = explode(' ',$keyword);
									$keyword = ''; // reset keyword
									if ($result) break;
								}
								while($length > 0);
							}			
							//print_r($result);
							$num_product = 1;
							foreach ($result->Items->Item as $item) 
							{
								if ($num_product == 1)
								{
									//print_r($item);
									@$product .=  "<br/><h2><a href=\"".$item->ItemLinks->ItemLink[0]->URL."\">Buy {$item->ItemAttributes->Title}</a></h2><br>"; 
									$product .= @$item->EditorialReviews->EditorialReview->Content ? "<h3>Product Description</h3>{$item->EditorialReviews->EditorialReview->Content}" : "<h3>Product Description</h3><p>Sorry, no description available.</p>";
									$product .= "<h3>Product Details</h3>";
									$product .= @$item->ItemAttributes->Binding ? "<p>Category : {$item->ItemAttributes->Binding}</p>" : "";
									$product .= @$item->ItemAttributes->Brand ? "<p>Brand : {$item->ItemAttributes->Brand}</p>" : "";
									$product .= @$item->ItemAttributes->Color ? "<p>Color : {$item->ItemAttributes->Color}</p>" : "";
									if (isset($item->ItemAttributes->Feature)) 
									{
										$product .= "<p>Product Feature : </p><ol>";
										$i = 0;
										for ($i; $i < count($item->ItemAttributes->Feature); $i++)
										{
											$product .= "<li>".$item->ItemAttributes->Feature[$i]."</li>";
										}
										$product .= "</ol>";									
									}
									$product .= @$item->ItemAttributes->ItemDimensions ? "<p>Product Dimension : {$item->ItemAttributes->ItemDimensions->Length} x {$item->ItemAttributes->ItemDimensions->Width} x {$item->ItemAttributes->ItemDimensions->Height} with weight {$item->ItemAttributes->ItemDimensions->Weight}</p>" : "";
									$product .= @$item->ItemAttributes->ListPrice ? "<p>Product Price : {$item->ItemAttributes->ListPrice->FormattedPrice}</p>" : "";							
									//$product .= "<br>ASIN : {$item->ASIN}<br>";
									if ($item->OfferSummary)
									{
										$product .= "<h3>Product Special Offer</h3>";
										$product .= "<p>Buy <a href=\"".$item->ItemLinks->ItemLink[0]->URL."\">{$item->ItemAttributes->Title}</a> now, get this interesting offer :</p>";
										$product .= "<p><b>Lowest new price : </b> {$item->OfferSummary->LowestNewPrice->FormattedPrice}, total new {$item->OfferSummary->TotalNew} item(s)</p>";
										$product .= "<p><b>Lowest used price : </b> {$item->OfferSummary->LowestUsedPrice->FormattedPrice}, total used {$item->OfferSummary->TotalUsed} item(s)</p>";
									}
									$product .= "<br><img src=\"" . $item->LargeImage->URL . "\" alt=\"{$item->ItemAttributes->Title}\"/><br><br>";
										
									
									if ($item->CustomerReviews->HasReviews == 'true')
									{
										$product .= "<h2>Customer Review for {$item->ItemAttributes->Title}</h2>";
										$product .= "<iframe src=\"".$item->CustomerReviews->IFrameURL."\" frameborder=\"0\" width=\"100%\" height=\"100%\"></iframe>";
									}
									$product .= "<h2>Related Product of {$item->ItemAttributes->Title}</h2>";
								}
								else
								{
									$product .= "<div style=\"margin: 10px 10px; padding-left: 10px;\"";
									$product .=  "<h3><a href=\"".$item->ItemLinks->ItemLink[0]->URL."\">{$item->ItemAttributes->Title}</a></h3>"; 
									$product .= "<table>";
									$product .= "<tr><td rowspan=\"4\"><img src=\"" . $item->MediumImage->URL . "\" alt=\"{$item->ItemAttributes->Title}\"/></td><td>ASIN : {$item->ASIN}<td></tr>";
									$product .= "<tr><td>Brand : {$item->ItemAttributes->Brand}<td></tr>";
									$product .= "<tr><td>List Price : {$item->ItemAttributes->ListPrice->FormattedPrice}<td></tr>";
									$product .= "<tr><td><b>Lowest new price : </b> {$item->OfferSummary->LowestNewPrice->FormattedPrice}<td></tr>";
									$product .= "</table>";
									$product .= "</div><br/>";
								}
								$num_product++;
							}
							$msg = $desc.$product;
							//echo $msg;
							$this->send_mail($data->email,$_title,$msg);
						}// END check 
					}
				}
				else
				{
					echo "No rss fedd";
				}
			}// END foreach 
		}
		else
		{
			echo "CAn't get rss";
		}
	}
	
	public function send_mail($email,$_title,$msg)
	{
		$this->load->library('email');
		$this->email->set_mailtype('html');
		$this->email->from('seto@nanocomputercorner.com', 'AmazeOn');
		$this->email->to($email);

		$this->email->subject($_title);
		$this->email->message($msg);	

		$this->email->send();

		echo $this->email->print_debugger();
	}
}

/* End of file campaign.php */
/* File location: ./amz/controller/campaign.php */