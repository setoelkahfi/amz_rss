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
}

/* End of file m_users.php */
/* File location: ./amz/models/m_users.php */