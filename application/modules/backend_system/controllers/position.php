<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends My_Controller{

	public $setconfig;

	function __construct(){
		parent::__construct();
		if(!isset($this->authentication) || is_array($this->authentication) == FALSE || count($this->authentication) == 0) redirect('backend_user/authentication/login');
		$this->load->model(array('mposition', 'mconfig'));
		$this->load->library('action', array('model' => 'mposition', 'table' => 'system_position'));
		$this->setconfig = $this->mposition->setconfig;
	}

	// Danh sách nhóm hệ thống
	public function index($page = 1){
		$page = (int)$page;
		$this->auth->permissions(array(
			'uri' => 'backend_system/position/index'
		));
		$this->action->_sort(array(
			'redirect' => $this->agent->referrer()
		));
		$config = backend_pagination();
		$config['base_url'] = base_url('backend_system/position/index');
		$config['total_rows'] = $this->mposition->count();
		if($config['total_rows'] > 0){
			$sort = sort_field($this->input->get('field'), $this->input->get('sort'));
			$config['sort'] = 'field='.$sort['field'].'&sort='.$sort['sort'];
			$config['param'] = URL_SUFFIX.'?keyword='.$this->input->get('keyword');
			$config['suffix'] = $config['param'].'&'.$config['sort'];
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$total_page = ceil($config['total_rows']/$config['per_page']);
			$config['cur_page'] = validate_pagination($page, $total_page);
			$this->pagination->initialize($config);
			$data['list_pagination'] = $this->pagination->create_links();
			$data['list_position'] = $this->mposition->show($config['per_page'], ($config['cur_page'] - 1), $sort);
		}
		$data['keyword'] = $this->input->get('keyword');
		$data['config'] = $config;
		$data['sort'] = isset($sort)?$sort:NULL;
		$data['meta_title'] = 'Quản lý nhóm hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/position/index';
		$this->load->view('backend/layout/home', $data);
	}

	// Thêm mới nhóm hệ thống
	public function add(){
		$this->auth->permissions(array(
			'uri' => 'backend_system/position/add',
			'redirect' => 'backend_system/position/index'
		));
		if($this->input->post('submit')){
			$this->form_validation->set_rules($this->mposition->validation);
			$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required|callback__keyword');
			if ($this->form_validation->run()){
				$resultid = $this->mposition->insert();
				if($resultid >= 1){
					message_flash('Thêm mới nhóm hệ thống '.$this->input->post('title').' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_system/position/index');
			}
		}
		$data['meta_title'] = 'Thêm nhóm hệ thống mới';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/position/add';
		$this->load->view('backend/layout/home', $data);
	}
	
	// Cập nhật nhóm hệ thống
	public function updated($id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_system/position/updated',
			'redirect' => 'backend_system/position/index'
		));
		$data['position'] = $this->mposition->get_byid($id);
		if($this->input->post('submit')){
			$this->form_validation->set_rules($this->mposition->validation);
			if($data['position']['keyword'] != slug($this->input->post('keyword'))){
				$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required|callback__keyword');
			}
			if($this->form_validation->run()){
				$flag = $this->mposition->update_byid($id);
				if($flag >= 1){
					message_flash('Cập nhật nhóm hệ thống '.$data['position']['title'].' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_system/group/index');
			}
		}
		$data['meta_title'] = 'Cập nhật nhóm hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/position/update';
		$this->load->view('backend/layout/home', $data);
	}

	// Callback keyword
	public function _keyword($keyword = ''){
		$keyword = slug($keyword);
		$count = $this->mposition->count_bykeyword($keyword);
		if($count > 0){
			$this->form_validation->set_message('_keyword', 'Keyword '.$keyword.' đã tồn tại!');
			return FALSE;
		}
		return TRUE;
	}

	// Xóa nhóm hệ thống
	public function delete($id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_system/position/delete',
			'redirect' => 'backend_system/position/index'
		));
		$data['position'] = $this->mposition->get_byid($id);
		if($this->input->post('submit')){
			$this->form_validation->set_rules('id', 'id', 'trim|required|callback__delete');
			if($this->form_validation->run()){
				$flag = $this->mposition->delete_byid($id);
				if($flag >= 1){
					message_flash('Xóa nhóm hệ thống '.$data['position']['title'].' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_system/position/index');
			}
		}
		$data['meta_title'] = 'Xóa nhóm hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/position/delete';
		$this->load->view('backend/layout/home', $data);
	}

	// Callback delete
	public function _delete($id = 0){
		$id = (int)$id;
		$count = $this->mconfig->count_bypositionid($id);
		if($count > 0){
			$this->form_validation->set_message('_delete', 'Nhóm hệ thống vẫn còn hệ thống!');
			return FALSE;
		}
		return TRUE;
	}

	// Thay đổi cấu hình nhóm hệ thống
	public function set($field, $id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_system/position/set',
			'redirect' => 'backend_system/position/index'
		));
		$data['position'] = $this->mposition->get_byid($id);
		$flag = $this->mposition->update_config_byid($id, array($field => ($data['position'][$field] == 1)?0:1));
		if($flag >= 1){
			message_flash('Thay đổi trạng thái nhóm hệ thống '.$data['position']['title'].' thành công!');
		}
		redirect(!empty($this->redirect)?$this->redirect:'backend_system/position/index');
	}

	// Thay đổi cấu hình nhóm hệ thống
	public function json($id, $redirect = ''){
		$id = (int)($id);
		// $this->auth->permissions(array(
			// 'uri' => 'backend_system/position/json',
			// 'redirect' => 'backend_system/position/index'
		// ));
		$data['position'] = $this->mposition->get_byid($id);		
		$config = $this->mconfig->show_bypositionid($data['position']['id']);
		if(isset($config) && is_array($config) && count($config)){
			$temp = NULL;
			foreach($config as $key => $val){
				$temp[$val['keyword']] = $val['content'];
			}
			$flag = $this->mposition->update_config_byid($id, array('content_'.$this->language => json_encode($temp)));
			if($flag >= 1){
				message_flash('Cập nhật Json '.$data['position']['title'].' thành công!');
			}
		}
		if(!empty($redirect)){
			redirect('backend_system/system/index/'.$redirect);
		}
		redirect(!empty($this->redirect)?$this->redirect:'backend_system/position/index');
	}
}
