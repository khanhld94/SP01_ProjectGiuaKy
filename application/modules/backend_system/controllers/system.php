<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends My_Controller{

	public $setconfig;

	function __construct(){
		parent::__construct();
		if(!isset($this->authentication) || is_array($this->authentication) == FALSE || count($this->authentication) == 0) redirect('backend_user/authentication/login');
		$this->load->model('msystem');
	}

	// Cấu hình nhóm hệ thống
	public function index($type = ''){
		$this->auth->permissions(array(
			'uri' => 'backend_system/system/index'
		));
		$redirect = '';
		$data['list_position'] = $this->msystem->listposition();
		if(empty($type)){
			$position = current($data['list_position']);
			$redirect = $position['keyword'];
			$data['list_config'] = $this->msystem->listconfig_bypositionid($position['id']);
		}
		else{
			$position['id'] = 0;
			foreach($data['list_position'] as $key => $val){
				if($val['keyword'] == $type){
					$position['id'] = $val['id'];
					$redirect = $type;
				}
			}
			$data['list_config'] = $this->msystem->listconfig_bypositionid($position['id']);
		}
		if($this->input->post('submit')){
			$flag = $this->msystem->update();
			if($flag >= 1){
				message_flash('Thay đổi cấu hình nhóm hệ thống thành công');
			}
			redirect('backend_system/position/json/'.$position['id'].'/'.$redirect);
		}
		$data['type'] = $type;
		$data['meta_title'] = 'Cấu hình nhóm hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_system/system/index';
		$this->load->view('backend/layout/home', $data);
	}
}
