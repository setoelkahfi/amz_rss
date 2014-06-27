<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Champaign model
 *
 * Handle data model at campaign controller.
 *
 * @version 0.2
 * @update 01 March 2013
 * 		- add active field to the campaign table
 *		- add blog title field
 */
class M_campaign extends CI_Model {
	
	/**
	 * Get campaign.
	 *
	 * Get list of all campaign. If
	 */
	public function get_campaign($id = NULL)
	{
		$query = ($id) ? $this->db->get_where('amz_campaign',array('id'=>$id)) : $this->db->get('amz_campaign');
		return $query;
	}
	
	/**
	 * Get locale
	 */
	public function get_locale($locale = null)
	{
		$query = ($locale === null) ? $this->db->get('amz_locale') : $this->db->get_where('amz_locale',array('locale'=>$locale));
		return $query;
	}
	
	/**
	 * Get search index value
	 */
	public function get_search_index($locale)
	{
		$query = $this->db->get_where('amz_search_index', array( $locale => '1' ));
		return $query;
	}
	
	/**
	 * Get associate tag user
	 */
	public function get_tracking_id($locale)
	{
		$query = $this->db->get_where('amz_tracking_id', array( 'locale' => $locale, 'user_id' => $this->session->userdata['user_id'] ));
		return $query;
	}
	
	/**
	 * Get API key user
	 */
	public function get_api_key()
	{
		$query = $this->db->get_where('amz_api_key', array( 'user_id' => $this->session->userdata['user_id'] ));
		return $query;
	}
	
	/**
	 * Save the campaign
	 */
	public function save($blog_title, $blog_url, $rss, $locale, $category, $tracking_id, $public_key, $private_key, $email)
	{
		//  `id` ,  `user_id` ,  `link` ,  `locale` ,  `category` ,  `tracking_id` ,  `public_key` ,  `private_key` ,  `email` 
		$data = array(
			'blog_title' => $blog_title, 
			'blog_url' => $blog_url,
			'user_id' => $this->session->userdata('user_id'),
			'link' => $rss,
			'locale' => $locale,
			'category' => $category,
			'tracking_id' => $tracking_id,
			'public_key' => $public_key,
			'private_key' => $private_key,
			'email' => $email
		);
		$this->db->insert('amz_campaign',$data);
	}
	
	/**
	 * Get API key user
	 */
	public function delete($id)
	{
		return $this->db->delete('amz_campaign', array( 'id' => $id ));
	}
	
	/**
	 * Update Campaign
	 */
	public function update_status($id,$status)
	{
		$status_new = ($status == '1') ? '0' : '1';
		$this->db->where('id',$id);
		return $this->db->update('amz_campaign', array( 'status' => $status_new ));
	}
	
	/**
	 * Update Campaign All
	 */
	public function update($id, $blog_title, $blog_url, $rss, $locale, $category, $tracking_id, $public_key, $private_key, $email)
	{
		$data = array(
			'blog_title' => $blog_title, 
			'blog_url' => $blog_url,
			'user_id' => $this->session->userdata('user_id'),
			'link' => $rss,
			'locale' => $locale,
			'category' => $category,
			'tracking_id' => $tracking_id,
			'public_key' => $public_key,
			'private_key' => $private_key,
			'email' => $email
		);
		$this->db->where('id',$id);
		return $this->db->update('amz_campaign', $data);
	}
	
	/**
	 * Get campaign for cronjob
	 *
	 * Get list of all ACTIVE campaign.
	 */
	public function get_campaign_cron()
	{
		$data = array(
			'status' => 1
		);
		return $this->db->get_where('amz_campaign',$data);
	}
	
	/**
	 * Get item rss status, if already in database, then dont' process!
	 *
	 * @param string guid of item rss
	 * @param integer id campaign
	 */
	public function get_item_status($guid,$id)
	{
		$where = array(
			'guid' => $guid,
			'campaign_id' => $id
		);
		return $this->db->get_where('amz_item_status',$where);
	}
	
	/**
	 * Add item status to the table
	 *
	 * @param string guid of item rss
	 * @param integer id campaign
	 */
	public function add_item_status($guid,$id)
	{
		$data = array(
			'guid' => $guid,
			'campaign_id' => $id
		);
		return $this->db->insert('amz_item_status',$data);
	}
}

/* End of file m_campaign.php */
/* File location: ./amz/models/m_campaign.php */