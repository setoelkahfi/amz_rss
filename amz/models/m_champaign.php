<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Champaign model
 *
 * Handle data model at champaign
 */
class M_champaign extends CI_Model {
	
	/**
	 * Get user
	 */
	public function get_champaign($id = NULL)
	{
		$query = ($id) ? $this->db->get_where('amz_champaign',array('user_id'=>$id)) : $this->db->get('amz_champaign');
		return $query;
	}
	
	/**
	 * Get search index value
	 */
	public function get_search_index_value()
	{
		$query = $this->db->get_where('amz_champaign',array('user_id'=>'1'));
		return $query;
	}
}

/* End of file m_users.php */
/* File location: ./amz/models/m_users.php */