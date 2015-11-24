<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('frontend_article/marticle');
		$this->load->model('frontend_article/mexchange');
		$this->load->library('nestedset', array(
			'model' => 'mhome',
			'table' => 'article_catalogue'
		));
	}
	
	public function index(){
		if($this->check_login()){
				$data['notifi'] = $this->notifi;
			}
		if(!$this->check_login()) redirect('frontend_user/user/login');
		$data['keyword'] = $this->input->get('keyword');
		$data['catalogueid'] = $this->input->get('catalogueid');
		$data['dropdown_catalogueid']=$this->nestedset->dropdown(array('text'=>'Chọn danh mục'));
		//aside
		$data['catalogue'] = $this->mhome->list_catalogue_byparentid(0);
		foreach ($data['catalogue'] as $key => $value) {
		$data['catalogue'][$key]['children'] = $this->mhome->list_catalogue_byparentid($value['id']);
		}
		//content
		$config = backend_pagination();
		$config['base_url'] = base_url('frontend/manager/index');
		$config['total_rows'] = $this->mhome->count($this->user['id']);
		if($config['total_rows'] > 0){
			$config['param'] = URL_SUFFIX.'?keyword='.$this->input->get('keyword').'&catalogueid='.$this->input->get('catalogueid');
			$config['suffix'] = $config['param'];
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 5;
			$total_page = ceil($config['total_rows']/$config['per_page']);
			$config['cur_page'] = validate_pagination($page, $total_page);
			$this->pagination->initialize($config);
			$data['list_pagination'] = $this->pagination->create_links();
			$data['list_post'] = $this->mhome->show($config['per_page'], ($config['cur_page'] - 1),NULL,$this->user['id']);
		}
		$data['template'] = 'home/manager';
		$this->load->view('frontend/layout/home', $data);
	}

	public function exchange($id = 0){
		$data['catalogue'] = $this->mhome->list_catalogue_byparentid(0);
		foreach ($data['catalogue'] as $key => $value) {
		$data['catalogue'][$key]['children'] = $this->mhome->list_catalogue_byparentid($value['id']);
		}
		if(!isset($this->user) || !is_array($this->user) || !count($this->user)) redirect('frontend_user/user/login');
		$data['product2'] = json_decode($this->session->userdata('exchangeid'),TRUE);
		$data['product1'] = $this->marticle->get_post_byid($id,$this->user['id']);
		if($this->mexchange->check_exchange($data['product1']['id']))
		{
			message_flash('Mặt hàng '.$data['product1']['title'].' đã được chọn để trao đổi đang chờ xác nhận');
			redirect('frontend/manager');
		}else{
		$data['userid2'] = $this->mhome->get_user_byid($data['product2']['userid_created']);
		$data['userid1'] = $this->mhome->get_user_byid($data['product1']['userid_created']);
		if($this->input->post('submit')){
		$flat = $this->mhome->insert(array(
				'UserSend' => $data['userid1']['id'],
				'UserRe' => $data['userid2']['id'],
				'ID1'=> $data['product1']['id'],
				'ID2' => $data['product2']['id'],
				'TT1' => 0,
				'TT2' => 0
				));
			if(!$flat){ 
				message_flash('Đã gửi thông báo xác nhận trao đổi');
				redirect(site_url('frontend/home'));
				}
			}
		}
		$data['template'] = 'home/change';
		//print_r($data);
		$this->load->view('frontend/layout/home', $data);
	}
}
