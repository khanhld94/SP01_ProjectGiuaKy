<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller{

	function __construct(){
		parent::__construct();	
		$this->load->library('nestedset', array(
			'model' => 'mhome',
			'table' => 'article_catalogue'
		));
	}
	
	public function index($page = 1){		
		//aside
		if($this->check_login()){
				$data['notifi'] = $this->notifi;
			}
		$data['catalogue'] = $this->mhome->list_catalogue_byparentid(0);
		foreach ($data['catalogue'] as $key => $value) {
		$data['catalogue'][$key]['children'] = $this->mhome->list_catalogue_byparentid($value['id']);
		}

		//content
		$data['template'] = 'frontend/home/index';
		if($page == 0) $page = 1;
		$data['dropdown_catalogueid']=$this->nestedset->dropdown(array('text'=>'Chọn danh mục'));
		// Tìm kiếm ở đây :
		$data['keyword'] = $this->input->get('keyword');
		$data['catalogueid'] = $this->input->get('catalogueid');
///////////////
		$config = backend_pagination();
		$config['base_url'] = base_url('frontend/home/index');
		$config['total_rows'] = $this->mhome->count();
		
		if($config['total_rows'] > 0){
			$config['param'] = URL_SUFFIX.'?keyword='.$this->input->get('keyword').'&catalogueid='.$this->input->get('catalogueid');
			$config['suffix'] = $config['param'];
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 5;
			$total_page = ceil($config['total_rows']/$config['per_page']);
			$config['cur_page'] = validate_pagination($page, $total_page);
			$this->pagination->initialize($config);
			$data['list_pagination'] = $this->pagination->create_links();
			$data['list_post'] = $this->mhome->show($config['per_page'], ($config['cur_page'] - 1),NULL);
		}

		$this->load->view('layout/home', $data);
	}
}
