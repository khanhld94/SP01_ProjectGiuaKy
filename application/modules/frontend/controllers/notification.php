<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('nestedset', array(
			'model' => 'mhome',
			'table' => 'article_catalogue'
		));
	}
	
	public function index(){
		if(!$this->check_login()) redirect('frontend_user/authentication/login');
		
		$data['notifi'] = $this->notifi;
		$data['dropdown_catalogueid']=$this->nestedset->dropdown(array('text'=>'Chọn danh mục'));
		$data['catalogue'] = $this->mhome->list_catalogue_byparentid(0);
		foreach ($data['catalogue'] as $key => $value) {
		$data['catalogue'][$key]['children'] = $this->mhome->list_catalogue_byparentid($value['id']);
		}
		foreach ($data['notifi'] as $key => $value){
			$data['UserSend'][$key] = $this->mhome->get_user_byid($value['UserSend']);
		}

		$data['template'] = 'frontend/home/notif';
		$this->load->view('layout/home', $data);
	}
}
