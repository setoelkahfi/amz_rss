<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users model
 *
 * The first controller to be loaded. Serves as the home page of the apps.
 */
class M_users extends CI_Model {
	
	/**
	 * Get user
	 */
	public function get_users($id = NULL)
	{
		$query = ($id) ? $this->db->get_where('amz_users',array('user_id'=>$id)) : $this->db->get('amz_users');
		return $query;
	}
	
	/**
	 * Login user (ajax request)
	 *
	 */
	public function login($user_id, $pass)
	{
		$data = array('user_email' => $user_id, 
			'user_password' => $pass
		);
		$query = $this->db->get_where('amz_users',$data);
		
		return $query;
	}
	
	/**
	 * Get locale for tracking id input
	 */
	public function get_locale()
	{
		$query = $this->db->get('amz_locale');
		
		return $query;
	}
	
	/**
	 * Get tracking id of the users
	 *
	 */
	public function get_tracking_id($id=NULL)
	{
		$query = ($id === NULL) ? $this->db->get_where('amz_tracking_id',array('user_id' => $this->session->userdata('user_id'))) : $this->db->get_where('amz_tracking_id',array('user_id' => $this->session->userdata('user_id'),'id' => $id));
		
		return $query;
	}
	
	/**
	 * Save new tracking id of the user
	 *
	 */
	public function save_tracking_id($tracking_id,$locale)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'tracking_id' => $tracking_id,
			'locale' => $locale
		);
		return $this->db->insert('amz_tracking_id',$data);
	}
	
	/**
	 * Delete tracking id of the user
	 *
	 */
	public function delete_tracking_id($id)
	{
		$data = array(
			'id' => $id
		);
		return $this->db->delete('amz_tracking_id',$data);
	}
	/**
	 * Get api keys of the user
	 *
	 */
	public function get_api_key($id=NULL)
	{
		$query = $this->db->get_where('amz_api_key',array('user_id' => $this->session->userdata('user_id')));
		
		return $query;
	}
	
	/**
	 * Save new api key of the user
	 *
	 */
	public function save_api_key($public_key,$private_key)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'public_key' => $public_key,
			'private_key' => $private_key
		);
		return $this->db->insert('amz_api_key',$data);
	}
	
	/**
	 * Delete api key of the user
	 *
	 */
	public function delete_api_key($id)
	{
		$data = array(
			'id' => $id
		);
		return $this->db->delete('amz_api_key',$data);
	}
}

/* End of file m_users.php */
/* File location: ./amz/models/m_users.php */