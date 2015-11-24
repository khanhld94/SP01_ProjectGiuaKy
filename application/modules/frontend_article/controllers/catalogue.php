<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogue extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model(array('marticle'));
		$this->load->library('nestedset', array(
			'model' => 'marticle',
			'table' => 'article_catalogue'
		));
	}
	
	public function index($catalogueid = 0, $page = 1){
		$catalogueid = (int)$catalogueid;
		$page = (int)$page;
		$data['catalogue'] = $this->marticle->get_catalogue_byid($catalogueid);
		$data['children_direct'] = $this->marticle->list_catalogue_byparentid($catalogueid);
		$data['breadcrumb'] = $this->nestedset->breadcrumb(array('lft' => $data['catalogue']['lft'], 'rgt' => $data['catalogue']['rgt']));
		if($data['catalogue']['rgt'] - $data['catalogue']['lft'] > 1){
			$data['children_indirect'] = $this->nestedset->children(array('andparent' => TRUE, 'lft' => $data['catalogue']['lft'], 'rgt' => $data['catalogue']['rgt']));
		}
		
		$config = frontend_pagination();
		$config['base_url'] = rewrite_url(array(
			'module' => 'article_catalogue',
			'canonical' => $data['catalogue']['canonical'],
			'slug' => $data['catalogue']['slug'],
			'id' => $data['catalogue']['id'],
			'suffix' => ''
		));
		$config['total_rows'] = $this->marticle->count_post($catalogueid, isset($data['children_indirect'])?$data['children_indirect']:NULL);
		if($config['total_rows'] > 0){
			$config['suffix'] = URL_SUFFIX;
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 5;
			$config['total_page'] = ceil($config['total_rows']/$config['per_page']);
			$config['cur_page'] = validate_pagination($page, $config['total_page']);
			$this->pagination->initialize($config);
			$data['list_pagination'] = $this->pagination->create_links();
			$data['list_post'] = $this->marticle->list_post($catalogueid, isset($data['children_indirect'])?$data['children_indirect']:NULL, $config['per_page'], ($config['cur_page'] - 1));
			$seo = seo_pagination($config);
			$data['canonical'] = isset($seo['canonical'])?$seo['canonical']:'';
			$data['prev'] = isset($seo['prev'])?$seo['prev']:'';
			$data['next'] = isset($seo['next'])?$seo['next']:'';
		}
		else{
			$data['canonical'] = $config['base_url'].URL_SUFFIX;
		}
		$data['meta_title'] = (!empty($data['catalogue']['meta_title'])?$data['catalogue']['meta_title']:$data['catalogue']['title']).(($page > 1)?' - Trang '.$page:'');
		$data['meta_description'] = (!empty($data['catalogue']['meta_description'])?$data['catalogue']['meta_description']:cutnchar(strip_tags($data['catalogue']['description']), 255)).(($page > 1)?' - Trang '.$page:'');
		$data['meta_keywords'] = $data['catalogue']['meta_keywords'];
		$data['template'] = 'frontend_article/catalogue/index';
		$data['list_catalogue']=$this->marticle->list_catalogue_byparentid(0);
		$data['slide'] = $this->mslide->show_bygroupid(1);
		$this->load->view('frontend/layout/home', $data);
	}
}
