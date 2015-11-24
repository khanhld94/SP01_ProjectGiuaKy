<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

	private $authentication;
	public $user;
	public $language;
	public $redirect;
	public $system;
	public $useragent;
	public $notifi;
	function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		// Load thư viện cần thiết
		$this->load->library(array('form_validation', 'session', 'pagination', 'user_agent', 'cart'));
		$this->load->helper(array('url', 'mystring', 'mypagination', 'myuri','date'));
		// Language
		$this->language = language_current();
		$this->config->set_item('language', $this->language);
		$this->lang->load('biegr');
		// Frontend
			$this->load->model(array('backend_system/msystem', 'frontend_user/mauth'));
			$this->load->library(array('auth'));
			$this->load->model(array('frontend/mhome'));
			$this->authentication = $this->auth->check();
			if(isset($this->authentication)&&is_array($this->authentication)&&count($this->authentication)){
				$this->notifi = $this->mhome->notifi();
			}
			$this->load->helper(array('mynavigation'));
		
		// Redirect
		$redirect = $this->input->get('redirect');
		$this->redirect = !empty($redirect)?base64_decode($redirect):'';
		$this->user = $this->authentication; 
		// Thông tin
		$this->useragent = $this->agent->agent_string();
	}

	public function check_login(){
		if(isset($this->authentication) && is_array($this->authentication) && count($this->authentication))
			return 1;
		else return 0;
	}
	public function userInfo(){
		$user  = $this->authentication;
		return $user;
	}

}
