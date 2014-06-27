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
 
class Amz extends CI_Controller {

	/**
	 * The constructor
	 */
	public function index()
	{
		$this->output->enable_profiler(true);
		$data['title'] = 'Read Amazon (or another) RSS realtime on your e-mail!';
		$data['page'] = 'amz/index';
		$this->load->view('template',$data);
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

/* End of file amz.php */
/* Location: ./application/controllers/amz.php */