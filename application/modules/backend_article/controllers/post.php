<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

interface action_post{
	public function action();
}

class Post extends My_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->check_login()) redirect('frontend_user/authentication/login');
		$this->load->model(array('mcatalogue', 'mpost'));
		$this->load->library('nestedset', array(
			'model' => 'mcatalogue',
			'table' => 'article_catalogue'
		));
		$this->load->library('action', array(
			'model' => 'mpost',
			'table' => 'article'
		));
		$this->load->library('RouterBie');
		$user =  $this->userInfo();
	}

	// Danh sách bài viết
	public function index($page = 1){
		$page = (int)$page;
		$this->auth->permissions(array(
			'uri' => 'backend_article/post/index'
		));
		$mng = new show_post($this,$page);
		$mng->action();
	}
	public function add($id){
		$this->auth->permissions(array(
			'uri' => 'backend_article/post/add',
			'redirect' => 'backend_article/post/index'
		));
		$mng = new add_post($this);
		$mng->action();
	}
	public function update($id){
		$id = (int)$id;
		$this->auth->permissions(array(
			'uri' => 'backend_article/post/add',
			'redirect' => 'backend_article/post/index'
		));
		$mng = new update_post($this,$id);
		$mng->action();
	}
	public function delete($id){
		$id = (int)$id;
		$this->auth->permissions(array(
			'uri' => 'backend_article/post/add',
			'redirect' => 'backend_article/post/index'
		));
		$mng = new delete_post($this,$id);
		$mng->action();
	}
}

class show_post implements action_post{
	private $data;
	private $call;
	private $page;

	public function show_post($call=NULL,$page=NULL){
		$this->call = $call;
		$this->data = $call->input;
		$this->page = $page;
	}
	public function action(){
		//phân trang
		$total_rows = $this->call->mpost->count();
		$base_url = base_url('backend_article/post/index');
		$pagination = new Pagination($this->call,$base_url,$total_rows,$this->page,4);	
		$data['list_pagination'] = $pagination->result();
		//show
		$data['list_post'] = $this->call->mpost->show($pagination->per_page,($this->page - 1),NULL);
		$data['keyword'] = $this->data->get('keyword');
		$data['catalogueid'] = $this->data->get('catalogueid');
		$data['dropdown_catalogueid'] = $this->call->nestedset->dropdown(array('text' => '- Chọn danh mục -'));
		$data['meta_title'] = 'Quản lý bài đăng';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_article/post/index';
		$this->call->load->view('backend/layout/home', $data);
	}
}

class add_post implements action_post{
	private $data;
	private $call;
	public function add_post($call=NULL){
		$this->call = $call;
		$this->data = $call->input;
	}
	public function action(){
		if($this->data->post('submit')){
			//Nguyên lý 2 . Mở rộng với thay đổi
			$this->call->form_validation->set_rules($this->call->mpost->validation);

			if ($this->call->form_validation->run()){
				$resultid = $this->call->mpost->insert();
				if($resultid >= 1){
					message_flash('Thêm bài viết '.$this->data->post('title').' thành công');
				}
				redirect(!empty($this->call->redirect)?$this->call->redirect:'backend_article/post/index');
			}
		}
		$data['dropdown_catalogueid'] = $this->call->nestedset->dropdown(array('text' => '- Chọn danh mục -'));
		$data['meta_title'] = 'Thêm bài viết mới';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_article/post/add';
		$this->call->load->view('backend/layout/home', $data);

	}
}
class update_post implements action_post{
	private $data;
	private $id;
	private $call;

	public function update_post($call=NULL,$id = NULL){
		$this->call = $call;
		$this->data = $call->input;
		$this->id = $id;
	}
	public function action(){
		$data['post'] = $this->call->mpost->get_byid($this->id);
		if($this->data->post('submit')){
			$this->call->form_validation->set_rules($this->call->mcatalogue->validation);

			if($this->call->form_validation->run()){
				$flag = $this->call->mpost->update_byid($this->id);
				if($flag >= 1){
					message_flash('Thay đổi bài viết '.$data['post']['title'].' thành công');
				}
				redirect(!empty($this->call->redirect)?$this->call->redirect:'backend_article/post/index');
			}
		}
		$data['dropdown_catalogueid'] = $this->call->nestedset->dropdown(array('text' => '- Chọn danh mục -'));
		$data['meta_title'] = 'Cập nhật sản phẩm';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_article/post/update';
		$this->call->load->view('backend/layout/home', $data);
	}
}

class delete_post{
	private $id;
	private $call;
	private $data;

	public function delete_post($call,$id){
		$this->call = $call;
		$this->id = $id;
		$this->data = $call->input;
	}
	public function action(){
		$data['post'] = $this->call->mpost->get_byid($this->id);
		if($this->data->post('submit')){
			$flag = $this->call->mpost->delete_byid($this->id);
			if($flag >= 1){
				message_flash('Xóa bài viết '.$data['post']['title'].' thành công');
			}
			redirect(!empty($this->call->redirect)?$this->call->redirect:'backend_article/post/index');
		}
		$data['meta_title'] = 'Xóa bài viết';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_article/post/delete';
		$this->call->load->view('backend/layout/home', $data);
	}
}

//Nguyên lý 1 
class Pagination{
	private $url;
	private $total;
	private	$page;
	private $config;
	private $call;
	public $per_page;
	public $data;

	function Pagination($call=NULL,$base_url=NULL,$total_rows=0,$page = 0,$per_page){
		$this->url = $base_url;
		$this->total = $total_rows;
		$this->page = $page;
		$this->config = backend_pagination();
		$this->call = $call;
		$this->per_page = $per_page;
	}
	public function result(){
		$this->config['base_url'] = $this->url;
		$this->config['total_rows'] = $this->total;
		if($this->config['total_rows'] > 0){
			$this->config['param'] = URL_SUFFIX.'?keyword='.$this->call->input->get('keyword').'&catalogueid='.$this->call->input->get('catalogueid');
			$this->config['suffix'] = $this->config['param'];
			$this->config['first_url'] = $this->config['base_url'].$this->config['suffix'];
			$this->config['per_page'] = $this->per_page;
			$total_page = ceil($this->config['total_rows']/$this->config['per_page']);
			$this->config['cur_page'] = validate_pagination($this->page, $total_page);
			$this->call->pagination->initialize($this->config);
			$data = $this->call->pagination->create_links();
		}
		return $data;
	}

}