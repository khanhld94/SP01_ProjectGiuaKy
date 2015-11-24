<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model(array(
			'marticle'
		));
		$this->load->library('nestedset', array(
			'model' => 'marticle',
			'table' => 'article_catalogue'
		));
	}
	
	public function index($id = 0){
		$id = (int)$id;
		$data['post'] = $this->marticle->get_post_byid($id);
		$data['user'] = $this->mhome->get_user_byid($data['post']['userid_created']);
		if($data['user']['id']==$this->user['id']){
			message_flash($data['post']['title'].' là mặt hàng của ban');
			redirect('frontend/home/index');
		}
		$this->session->set_userdata('exchangeid',json_encode($data['post']));
		message_flash('Chọn mặt hàng để trao đổi với '.$data['post']['title'].' của '.$data['user']['fullname']);
		redirect('frontend/manager/index');
	}
}
