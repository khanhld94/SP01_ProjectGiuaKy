<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model(array(
			'marticle',
			'frontend/mhome'
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
		$data['catalogue'] = $this->marticle->list_catalogue_byparentid(0);
		
		foreach ($data['catalogue'] as $key => $value) {
		$data['catalogue'][$key]['children'] = $this->marticle->list_catalogue_byparentid($value['id']);
		}

		$data['template'] = 'frontend_article/post/index';
		$this->load->view('frontend/layout/home', $data);
	}
}
