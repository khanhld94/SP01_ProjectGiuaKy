<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogue extends My_Controller{

	public $setconfig;

	function __construct(){
		parent::__construct();
		if(!isset($this->authentication) || is_array($this->authentication) == FALSE || count($this->authentication) == 0) redirect('backend_user/authentication/login');
		$this->load->model(array('mcatalogue', 'mpost'));
		$this->load->library('nestedset', array(
			'model' => 'mcatalogue',
			'table' => 'article_catalogue'
		));
		$this->load->library('action', array(
			'model' => 'mcatalogue',
			'table' => 'article_catalogue'
		));
		$this->load->library('RouterBie');
		$this->setconfig = $this->mcatalogue->setconfig;
	}

	// Danh sách danh mục
	public function index($page = 1){
		$page = (int)$page;
		$this->auth->permissions(array(
			'uri' => 'backend_article/catalogue/index'
		));
		$this->action->_sort(array(
			'nestedset' => TRUE,
			'redirect' => $this->agent->referrer()
		));
		$config = backend_pagination();
		$config['base_url'] = base_url('backend_article/catalogue/index');
		$config['total_rows'] = $this->mcatalogue->count();
		if($config['total_rows'] > 0){
			$config['sort'] = '';
			$config['param'] = URL_SUFFIX.'?keyword='.$this->input->get('keyword');
			$config['suffix'] = $config['param'].$config['sort'];
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 168;
			$total_page = ceil($config['total_rows']/$config['per_page']);
			$config['cur_page'] = validate_pagination($page, $total_page);
			$this->pagination->initialize($config);
			$data['list_pagination'] = $this->pagination->create_links();
			$data['list_catalogue'] = $this->mcatalogue->show($config['per_page'], ($config['cur_page'] - 1));
		}
		$data['keyword'] = $this->input->get('keyword');
		$data['config'] = $config;
		$data['meta_title'] = 'Quản lý danh mục';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['config'] = $config;
		$data['template'] = 'backend_article/catalogue/index';
		$this->load->view('backend/layout/home', $data);
	}
	
	// Thêm mới danh mục
	public function add(){
		$this->auth->permissions(array(
			'uri' => 'backend_article/catalogue/add',
			'redirect' => 'backend_article/catalogue/index'
		));
		if($this->input->post('submit')){
			$this->form_validation->set_rules($this->mcatalogue->validation);
			$canonical = slug($this->input->post('canonical'));
			if(!empty($canonical)){
				$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__canonical');
			}
			if ($this->form_validation->run()){
				$resultid = $this->mcatalogue->insert();
				if($resultid >= 1){
					if(!empty($canonical)){
						$this->routerbie->insert(array(
							'slug' => $canonical,
							'module' => 'article_catalogue',
							'moduleid' => $resultid
						));
					}
					$this->nestedset->get(array('orderby' => 'level ASC, order ASC, id ASC'));
					$this->nestedset->recursive(0, $this->nestedset->set());
					$this->nestedset->action();
					message_flash('Thêm danh mục '.$this->input->post('title').' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
			}
		}
		$data['dropdown_parentid'] = $this->nestedset->dropdown();
		$data['meta_title'] = 'Thêm danh mục mới';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_article/catalogue/add';
		$this->load->view('backend/layout/home', $data);
	}
	
	// Cập nhật danh mục
	public function updated($id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_article/catalogue/updated',
			'redirect' => 'backend_article/catalogue/index'
		));
		$data['catalogue'] = $this->mcatalogue->get_byid($id);
		if($this->input->post('submit')){
			$this->form_validation->set_rules($this->mcatalogue->validation);
			$canonical = slug($this->input->post('canonical'));
			if(!empty($canonical) && $canonical != $data['catalogue']['canonical']){
				$this->form_validation->set_rules('canonical', 'Canonical', 'trim|required|callback__canonical');
			}
			if($data['catalogue']['parentid'] != $this->input->post('parentid')){
				$this->form_validation->set_rules('parentid', 'Danh mục cha', 'trim|required|callback__catalogue['.$data['catalogue']['id'].']');
			}
			if($this->form_validation->run()){
				$flag = $this->mcatalogue->update_byid($id);
				if($flag >= 1){
					$this->routerbie->updated(array(
						'slug' => $canonical,
						'old' => $data['catalogue']['canonical'],
						'module' => 'article_catalogue',
						'moduleid' => $data['catalogue']['id']
					));
					$this->nestedset->get(array('orderby' => 'level ASC, order ASC, id ASC'));
					$this->nestedset->recursive(0, $this->nestedset->set());
					$this->nestedset->action();
					message_flash('Thay đổi danh mục '.$data['catalogue']['title'].' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
			}
		}
		$data['dropdown_parentid'] = $this->nestedset->dropdown();
		$data['meta_title'] = 'Cập nhật danh mục';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_article/catalogue/update';
		$this->load->view('backend/layout/home', $data);
	}

	public function _canonical($canonical = ''){
		$canonical = slug($canonical);
		$count = $this->routerbie->validate($canonical);
		if($count > 0){
			$this->form_validation->set_message('_canonical', 'Canonical đã tồn tại!');
			return FALSE;
		}
		return TRUE;
	}

	public function _catalogue($parentid = 0, $id = 0){
		$parentid = (int)$parentid;
		$id = (int)$id;
		if($parentid == $id){
			$this->form_validation->set_message('_catalogue', 'Không được chọn chính nó làm cha!');
			return FALSE;
		}
		$children = $this->nestedset->children(array('id' => $id));
		if(isset($children) && is_array($children) && in_array($parentid, $children)){
			$this->form_validation->set_message('_catalogue', 'Không được chọn danh mục làm cha!');
			return FALSE;
		}
		return TRUE;
	}
	
	public function delete($id){
		$id = (int)$id;
		$this->auth->permissions(array(
			'uri' => 'backend_article/catalogue/delete',
			'redirect' => 'backend_article/catalogue/index'
		));
		$data['catalogue'] = $this->mcatalogue->get_byid($id);
		if($this->input->post('submit')){
			if($data['catalogue']['rgt'] - $data['catalogue']['lft'] != 1){
				message_flash('Vẫn còn danh mục con !', 'error');
				redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
			}
			$this->form_validation->set_rules('id', 'id', 'trim|required|callback__delete');
			if($this->form_validation->run()){
				$flag = $this->mcatalogue->delete_byid($id);
				if($flag >= 1){
					if(!empty($data['catalogue']['canonical'])){
						$this->routerbie->delete_bymod(array(
							'module' => 'article_catalogue',
							'moduleid' => $id
						));
					}
					$this->nestedset->get(array('orderby' => 'level ASC, order ASC, id ASC'));
					$this->nestedset->recursive(0, $this->nestedset->set());
					$this->nestedset->action();
					message_flash('Xóa danh mục '.$data['catalogue']['title'].' thành công');
				}
				redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
			}
		}
		$data['meta_title'] = 'Xóa danh mục';
		$data['meta_description'] = '';
		$data['meta_keywords'] = '';
		$data['template'] = 'backend_article/catalogue/delete';
		$this->load->view('backend/layout/home', $data);
	}

	public function _delete($id = 0){
		$id = (int)$id;
		$count = $this->mpost->count_bycatalogueid($id);
		if($count > 0){
			$this->form_validation->set_message('_delete', 'Danh mục vẫn còn bài viết!');
			return FALSE;
		}
		return TRUE;
	}

	// Thay đổi cấu hình chuyên mục
	public function set($field, $id){
		$id = (int)($id);
		$this->auth->permissions(array(
			'uri' => 'backend_article/catalogue/set',
			'redirect' => 'backend_article/catalogue/index'
		));
		if(!isset($this->setconfig[$field])){
			message_flash('Chức năng không hỗ trợ cho field '.$field, 'error');
			redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
		}
		$data['catalogue'] = $this->mcatalogue->get_byid($id);
		$flag = $this->mcatalogue->update_config_byid($id, array($field => ($data['catalogue'][$field] == 1)?0:1));
		if($flag >= 1){
			message_flash('Thay đổi trạng thái danh mục '.$data['catalogue']['title'].' thành công!');
		}
		redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
	}
}
