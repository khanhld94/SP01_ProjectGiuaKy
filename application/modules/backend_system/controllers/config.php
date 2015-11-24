<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class config extends My_Controller{

	public $setconfig;

	function __construct(){
		parent::__construct();
		if(!$this->check_login()) redirect('backend_user/authentication/login');
		$this->load->model(array('mposition', 'mconfig'));
		$this->load->library('action', array(
			'model' => 'mconfig',
			'table' => 'system_config'
		));
		$this->setconfig = $this->mposition->setconfig;
	}

	// Danh sách hệ thống
	public function index($page = 1){
		$page = (int)$page;
		$this->auth->permissions(array(
			'uri' => 'backend_system/config/index'
		));
		$this->action->_sort(array(
			'redirect' => $this->agent->referrer()
		));
		$config = backend_pagination();
		$config['base_url'] = base_url('backend_system/config/index');
		$config['total_rows'] = $this->mconfig->count();
		if($config['total_rows'] > 0){
			$sort = sort_field($this->input->get('field'), $this->input->get('sort'));
			$config['sort'] = 'field='.$sort['field'].'&sort='.$sort['sort'];
			$config['param'] = URL_SUFFIX.'?keyword='.$this->input->get('keyword').'&positionid='.$this->input->get('positionid');
			$config['suffix'] = $config['param'].'&'.$config['sort'];
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$total_page = ceil($config['total_rows']/$config['per_page']);
			$config['cur_page'] = validate_pagination($page, $total_page);
			$this->pagination->initialize($config);
			$data['list_pagination'] = $this->pagination->create_links();
			$data['list_config'] = $this->mconfig->show($config['per_page'], ($config['cur_page'] - 1), $sort);
		}
		$data['keyword'] = $this->input->get('keyword');
		$data['positionid'] = $this->input->get('positionid');
		$data['dropdown_positionid'] = $this->mposition->dropdown();
		$data['config'] = $config;
		$data['sort'] = isset($sort)?$sort:NULL;
		$data['meta_title'] = 'Quản lý hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/config/index';
		$this->load->view('backend/layout/home', $data);
	}
	
	// Thêm mới hệ thống
	public function add(){
		$this->auth->permissions(array(
			'uri' => 'backend_system/config/add',
			'redirect' => 'backend_system/config/index'
		));
		if($this->input->post('submit')){
			$this->form_validation->set_rules($this->mconfig->validation);
			$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required|callback__keyword');
			if ($this->form_validation->run()){
				$resultid = $this->mconfig->insert();
				if($resultid >= 1){
					message_flash('Thêm mới hệ thống '.$this->input->post('title').' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_system/config/index');
			}
		}
		$data['dropdown_positionid'] = $this->mposition->dropdown();
		$data['meta_title'] = 'Thêm mới hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/config/add';
		$this->load->view('backend/layout/home', $data);
	}

	// Callback keyword
	public function _keyword($keyword = ''){
		$keyword = slug($keyword);
		$count = $this->mconfig->count_bykeyword($keyword);
		if($count > 0){
			$this->form_validation->set_message('_keyword', 'Keyword '.$keyword.' đã tồn tại!');
			return FALSE;
		}
		return TRUE;
	}
	
	// Cập nhật hệ thống
	public function updated($id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_system/config/updated',
			'redirect' => 'backend_system/config/index'
		));
		$data['config'] = $this->mconfig->get_byid($id);
		if($this->input->post('submit')){
			$this->form_validation->set_rules($this->mconfig->validation);
			if($data['config']['keyword'] != slug($this->input->post('keyword'))){
				$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required|callback__keyword');
			}
			if($this->form_validation->run()){
				$flag = $this->mconfig->update_byid($id);
				if($flag >= 1){
					message_flash('Cập nhật hệ thống '.$data['config']['title'].' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_system/group/index');
			}
		}
		$data['dropdown_positionid'] = $this->mposition->dropdown();
		$data['meta_title'] = 'Cập nhật hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/config/update';
		$this->load->view('backend/layout/home', $data);
	}

	// Xóa nhóm hệ thống
	public function delete($id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_system/config/delete',
			'redirect' => 'backend_system/config/index'
		));
		$data['config'] = $this->mconfig->get_byid($id);
		if($this->input->post('submit')){
			$flag = $this->mconfig->delete_byid($id);
			if($flag >= 1){
				message_flash('Xóa hệ thống '.$data['config']['title'].' thành công');
			}
			redirect(!empty($this->redirect)?$this->redirect:'backend_system/config/index');
		}
		$data['meta_title'] = 'Xóa hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/config/delete';
		$this->load->view('backend/layout/home', $data);
	}

	// Thay đổi cấu hình hệ thống
	public function set($field, $id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_system/config/set',
			'redirect' => 'backend_system/config/index'
		));
		$data['config'] = $this->mconfig->get_byid($id);
		$flag = $this->mconfig->update_config_byid($id, array($field => ($data['config'][$field] == 1)?0:1));
		if($flag >= 1){
			message_flash('Thay đổi trạng thái hệ thống '.$data['config']['title'].' thành công!');
		}
		redirect(!empty($this->redirect)?$this->redirect:'backend_system/config/index');
	}

}
