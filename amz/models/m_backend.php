<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Back-end apps model
 *
 * An administration controller. User for update search index, browse node, and locale.
 *
 */
class M_backend extends CI_Model {
	
	/**
	 * The contructor
	 */
	public function __constructor()
	{
		parent::__construct();
	}
	
	/**
	 * Get search index values
	 *
	 * @param string optional search index value
	 * @return array result query
	 * @return bool false if there's no result
	 */
	public function get_search_index($id = NULL)
	{
		
		$query = ($id) ? $this->db->get_where('amz_search_index',array('name'=>$id)) : $query = $this->db->get('amz_search_index');
		return $query->result();
	}
	
	/**
	 * Save 
	 */
	public function save_search_index($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US)
	{
		$data = array(
			'name' => $name, 
			'CA' => $CA, 
			'CN' => $CN, 
			'DE' => $DE, 
			'ES' => $ES, 
			'FR' => $FR, 
			'IT' => $IT, 
			'JP' => $JP, 
			'UK' => $UK, 
			'US' => $US
		);
		$this->db->insert('amz_search_index',$data);
	}
	
	/**
	 * Update search index values
	 *
	 * @param string search index name
	 * @param bool availability
	 * @param bool availability
	 * @param bool availability
	 * @param bool availability
	 * @param bool availability
	 * @param bool availability
	 * @param bool availability
	 * @param bool availability
	 * @param bool availability
	 */
	public function update_search_index($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US)
	{
		$data = array(
			'name' => $name, 
			'CA' => $CA, 
			'CN' => $CN, 
			'DE' => $DE, 
			'ES' => $ES, 
			'FR' => $FR, 
			'IT' => $IT, 
			'JP' => $JP, 
			'UK' => $UK, 
			'US' => $US
		);
		$this->db->where(array('name' => $name)); 
		$this->db->update('amz_search_index',$data);
	}
	
	/**
	 * Get browse node id
	 *
	 * @param string optional search index value
	 * @return obj query
	 * @return bool false if there's no result
	 */
	public function get_browse_node_id($id = NULL)
	{
		
		$query = ($id) ? $this->db->get_where('amz_search_index',array('name'=>$id)) : $this->db->get('amz_browse_node_id');
		return $query;
	}
	
	/**
	 * Save browse node id
	 */
	public function save_browse_node_id($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US)
	{
		$data = array(
			'name' => $name, 
			'CA' => $CA, 
			'CN' => $CN, 
			'DE' => $DE, 
			'ES' => $ES, 
			'FR' => $FR, 
			'IT' => $IT, 
			'JP' => $JP, 
			'UK' => $UK, 
			'US' => $US
		);
		$this->db->insert('amz_browse_node_id',$data);
	}
	
	/**
	 * Get all users
	 *
	 * @param string optional search index value
	 * @return obj query
	 * @return bool false if there's no result
	 */
	public function get_users($id = NULL)
	{
		
		$query = ($id) ? $this->db->get_where('amz_users',array('name'=>$id)) : $this->db->get('amz_users');
		return $query;
	}
}

/* End of file m_backend.php */
/* Location: ./amz/models/m_backend.php */