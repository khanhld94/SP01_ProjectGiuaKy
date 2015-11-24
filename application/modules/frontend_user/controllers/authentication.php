<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends My_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('mauth');
	}
	// Đăng nhập vào hệ thống
	public function login(){
		if($this->check_login()) redirect('frontend/home/index');

		if($this->input->post('submit')){
			$this->form_validation->set_rules($this->mauth->validation_login);
			if ($this->form_validation->run()){
				$email = trim($this->input->post('email'));
				$user = $this->mauth->getuser_byemail($email, 'email, password, salt');
				$flag = $this->mauth->updateuser_byemail($email, array('last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600), 'http_user_agent' => $this->useragent));
				if($flag > 0){
					$remember = 1;
					// $remember = (int)$this->input->post('remember');
					$user['http_user_agent'] = $this->useragent;
					if($remember >= 1){
						$this->session->set_userdata('authentication', json_encode($user));
					}
					else if($remember == 0){
						$_SESSION['authentication'] = json_encode($user);
					}
					message_flash('Bạn đã đăng nhập thành công');
					redirect('frontend/home');
				}
			}
		}
		$data['meta_title'] = 'Đăng nhập vào hệ thống';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template']='frontend_user/authentication/login';
		$this->load->view('frontend/layout/authentication',$data);
	}
	public function register(){
		$this->load->model('muser');
		if($this->check_login()) redirect('frontend/home/index');
		if($this->input->post('submit')){
			print_r($this->input->post);
			$this->form_validation->set_rules($this->muser->validation);
			if ($this->form_validation->run()){
				if($this->muser->insert()){
					message_flash('Bạn đã đăng ký thành công');
					redirect('frontend_user/authentication/login');
				}
			}
		}
		$data['template']='frontend_user/authentication/register';
		$this->load->view('frontend/layout/authentication',$data);
	}
	// callback authentication
	public function _authentication($password = ''){
		$email = $this->input->post('email');
		$user = $this->mauth->getuser_byemail($email, 'email, password, salt');
		if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
			$this->form_validation->set_message('_authentication', 'Tài khoản không tồn tại');
			return FALSE;
		}
		$password_encode = encryption($password, $user['salt']);
		if($user['password'] != $password_encode){
			$this->form_validation->set_message('_authentication', 'Mật khẩu không đúng');
			return FALSE;
		}
		return TRUE;
	}

	// callback email
	public function _email($password = ''){
		$email = $this->input->post('email');
		$user = $this->mauth->getuser_byemail($email, 'email, password, salt');
		if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
			$this->form_validation->set_message('_email', 'Tài khoản không tồn tại');
			return FALSE;
		}
		return TRUE;
	}
	public function _checkemail($password = ''){
		$email = $this->input->post('email');
		$user = $this->mauth->getuser_byemail($email, 'email, password, salt');
		if(count($user) > 0){
			$this->form_validation->set_message('_checkemail', 'Tài khoản đã tồn tại');
			return FALSE;
		}
		return TRUE;
	}
	// Đăng xuất khỏi hệ thống
	public function logout(){
		if(!$this->check_login()) redirect('backend_user/authentication/login');
		if(isset($_SESSION['authentication'])){
			unset($_SESSION['authentication']);
		}
		if(isset($_SESSION['user_folder'])){
			unset($_SESSION['user_folder']);
		}
		$this->session->unset_userdata('authentication');
		if(isset($_SESSION) && count($_SESSION)){
			foreach($_SESSION as $key => $val){
				if(in_array(substr($key, 0, 3), array('fb_'))){
					$_SESSION[$key] = '';
					unset($_SESSION[$key]);
				}
			}
		}
		if(isset($_SESSION['access_token'])){
			$_SESSION['access_token'] = '';
			unset($_SESSION['access_token']);
		}
		redirect('frontend/home/index');
	}
}
