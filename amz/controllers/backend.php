<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Back-end apps
 *
 * An administration controller. User for update search index, browse node, and locale.
 *
 */
class backend extends CI_Controller {

	/** 
	 * The constructor
	 *
	 * Restrcit only for administrator.
	 */
	public function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('user_name') || $this->session->userdata('user_level') != 'admin')
		{
			$this->session->set_flashdata('msg','<div class="alert alert-error flash">You must login or register first to use this service</div>');
			redirect('/users/login/');
		}
		$this->load->model('m_backend');
	}
	
	/**
	 * Index function
	 *
	 */
	public function index()
	{
		$data['title'] = 'Administration';
		$data['page'] = 'backend/index';
		$this->load->view('template');
	}
	
	/**
	 * Profil page admin
	 *
	 */
	public function home()
	{
		$content = 'Welcome, this is an administrator area where you can add data to this apps.';
		echo $content;
	}
	/**
	 * Add new search index
	 *
	 * @param string action to be taken
	 * @param optional search index value to be edited
	 */
	public function search_index($action = NULL, $id = NULL)
	{
		if ($action == NULL)
		{
			$data['items'] = $this->m_backend->get_search_index();
			$data['title'] = 'Search Index';
			$data['page'] = 'backend/search_index';
			$this->load->view('backend/search_index',$data);
		}
		else
		{
			$this->output->enable_profiler(TRUE);
			switch ($action)
			{
				case 'add' :
					$data['title'] = 'Search Index -> Add';
					$data['page'] = 'backend/search_index_add';
					$this->load->view('template',$data);
					break;
				case 'edit' :
					if ( ! $id)
					{
						$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
						redirect('backend/search-index/');
					}
					if ($id == 'save')
					{
						$name = $this->input->post('name');
						$name_ = $this->input->post('name_');
						if ( empty($name))
						{
							$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
							redirect('backend/search-index/edit/'.$name_);
						}
						$CA	= $this->input->post('CA');
						$CN	= $this->input->post('CN');
						$DE	= $this->input->post('DE');
						$ES	= $this->input->post('ES');
						$FR	= $this->input->post('FR');
						$IT	= $this->input->post('IT');
						$JP	= $this->input->post('JP');
						$UK	= $this->input->post('UK');
						$US = $this->input->post('US');
						//$name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US
						$status = $this->m_backend->update_search_index($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US) ? 'true' : 'false';
						$msg = ($status) ? '<div class="alert alert-success flash">Successfully updated!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
						
						$this->session->set_flashdata('msg', $msg);
						redirect('backend/search-index/');
					}
					$data['items'] = $this->m_backend->get_search_index($id);
					$data['title'] = 'Search Index -> Edit';
					$data['page'] = 'backend/search_index_edit';
					$this->load->view('template',$data);
					break;
				case 'save' :
					$name = $this->input->post('name');
					if ( empty($name))
					{
						$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
						redirect('backend/search-index/add');
					}
					$CA	= $this->input->post('CA');
					$CN	= $this->input->post('CN');
					$DE	= $this->input->post('DE');
					$ES	= $this->input->post('ES');
					$FR	= $this->input->post('FR');
					$IT	= $this->input->post('IT');
					$JP	= $this->input->post('JP');
					$UK	= $this->input->post('UK');
					$US = $this->input->post('US');
					//$name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US
					$status = $this->m_backend->save_search_index($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US) ? 'true' : 'false';
					$msg = ($status) ? '<div class="alert alert-success flash">Successfully saved!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
					
					$this->session->set_flashdata('msg', $msg);
					redirect('backend/search-index/add');
					break;
			}
		}
	}
	
	/**
	 * Add new search index
	 *
	 * @param string action to be taken
	 * @param optional search index value to be edited
	 */
	public function browse_node($action = NULL, $id = NULL)
	{
		if ($action == NULL)
		{
			$data['items'] = $this->m_backend->get_browse_node_id();
			$data['title'] = 'Browse Node Id';
			$this->load->view('backend/browse_node_id',$data);
		}
		else
		{
			$this->output->enable_profiler(TRUE);
			switch ($action)
			{
				case 'add' :
					$data['title'] = 'Browse Node Id -> Add';
					$data['page'] = 'backend/browse_node_id_add';
					$this->load->view('template',$data);
					break;
				case 'edit' :
					if ( ! $id)
					{
						$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
						redirect('backend/browse_node_id/');
					}
					if ($id == 'save')
					{
						$name = $this->input->post('name');
						$name_ = $this->input->post('name_');
						if ( empty($name))
						{
							$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
							redirect('backend/browse_node_id/edit/'.$name_);
						}
						$CA	= $this->input->post('CA');
						$CN	= $this->input->post('CN');
						$DE	= $this->input->post('DE');
						$ES	= $this->input->post('ES');
						$FR	= $this->input->post('FR');
						$IT	= $this->input->post('IT');
						$JP	= $this->input->post('JP');
						$UK	= $this->input->post('UK');
						$US = $this->input->post('US');
						//$name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US
						$status = $this->m_backend->update_search_index($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US) ? 'true' : 'false';
						$msg = ($status) ? '<div class="alert alert-success flash">Successfully updated!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
						
						$this->session->set_flashdata('msg', $msg);
						redirect('backend/browse_node_id/');
					}
					$data['items'] = $this->m_backend->get_search_index($id);
					$data['title'] = 'Browse Node Id -> Edit';
					$data['page'] = 'backend/browse_node_id_edit';
					$this->load->view('template',$data);
					break;
				case 'save' :
					$name = $this->input->post('name');
					if ( empty($name))
					{
						$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
						redirect('backend/browse_node_id/add');
					}
					$CA	= $this->input->post('CA');
					$CN	= $this->input->post('CN');
					$DE	= $this->input->post('DE');
					$ES	= $this->input->post('ES');
					$FR	= $this->input->post('FR');
					$IT	= $this->input->post('IT');
					$JP	= $this->input->post('JP');
					$UK	= $this->input->post('UK');
					$US = $this->input->post('US');
					//$name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US
					$status = $this->m_backend->save_browse_node_id($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US) ? 'true' : 'false';
					$msg = ($status) ? '<div class="alert alert-success flash">Successfully saved!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
					
					$this->session->set_flashdata('msg', $msg);
					redirect('backend/browse_node_id/add');
					break;
			}
		}
	}
	
	/**
	 * Manage users
	 *
	 * @param string action to be taken
	 * @param optional search index value to be edited
	 */
	public function manage_users($action = NULL, $id = NULL)
	{
		if ($action == NULL)
		{
			$data['items'] = $this->m_backend->get_users();
			$data['title'] = 'Manage Users';
			$this->load->view('backend/users',$data);
		}
		else
		{
			$this->output->enable_profiler(TRUE);
			switch ($action)
			{
				case 'add' :
					$data['title'] = 'Browse Node Id -> Add';
					$data['page'] = 'backend/browse_node_id_add';
					$this->load->view('template',$data);
					break;
				case 'edit' :
					if ( ! $id)
					{
						$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
						redirect('backend/browse_node_id/');
					}
					if ($id == 'save')
					{
						$name = $this->input->post('name');
						$name_ = $this->input->post('name_');
						if ( empty($name))
						{
							$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
							redirect('backend/browse_node_id/edit/'.$name_);
						}
						$CA	= $this->input->post('CA');
						$CN	= $this->input->post('CN');
						$DE	= $this->input->post('DE');
						$ES	= $this->input->post('ES');
						$FR	= $this->input->post('FR');
						$IT	= $this->input->post('IT');
						$JP	= $this->input->post('JP');
						$UK	= $this->input->post('UK');
						$US = $this->input->post('US');
						//$name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US
						$status = $this->m_backend->update_search_index($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US) ? 'true' : 'false';
						$msg = ($status) ? '<div class="alert alert-success flash">Successfully updated!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
						
						$this->session->set_flashdata('msg', $msg);
						redirect('backend/browse_node_id/');
					}
					$data['items'] = $this->m_backend->get_search_index($id);
					$data['title'] = 'Browse Node Id -> Edit';
					$data['page'] = 'backend/browse_node_id_edit';
					$this->load->view('template',$data);
					break;
				case 'save' :
					$name = $this->input->post('name');
					if ( empty($name))
					{
						$this->session->set_flashdata('msg', '<div class="alert alert-warning flash">Upss, error occured! You must fillin\' the name.</div>');
						redirect('backend/browse_node_id/add');
					}
					$CA	= $this->input->post('CA');
					$CN	= $this->input->post('CN');
					$DE	= $this->input->post('DE');
					$ES	= $this->input->post('ES');
					$FR	= $this->input->post('FR');
					$IT	= $this->input->post('IT');
					$JP	= $this->input->post('JP');
					$UK	= $this->input->post('UK');
					$US = $this->input->post('US');
					//$name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US
					$status = $this->m_backend->save_browse_node_id($name, $CA, $CN, $DE, $ES, $FR, $IT, $JP, $UK, $US) ? 'true' : 'false';
					$msg = ($status) ? '<div class="alert alert-success flash">Successfully saved!</div>' : '<div class="alert alert-warning flash">Upss, error occured!</div>';
					
					$this->session->set_flashdata('msg', $msg);
					redirect('backend/browse_node_id/add');
					break;
			}
		}
	}
}

/* End of file backend.php */
/* Location: ./amz/controller/backend.php */