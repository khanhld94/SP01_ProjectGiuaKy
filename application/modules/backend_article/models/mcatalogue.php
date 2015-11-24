<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MCatalogue extends My_Model{

	private $article_catalogue = 'article_catalogue';
	public $setconfig;
	public $validation;

	function __construct($params = NULL){
		parent::__construct();
		$this->setconfig = array(
			'publish' => 'Xuất bản',
			'highlight' => 'Nổi bật',
		);
		$this->validation = array(
			array('field' => 'title', 'label' => 'Tên danh mục', 'rules' => 'trim|required'),
			array('field' => 'canonical', 'label' => 'Canonical', 'rules' => 'trim'),
			array('field' => 'parentid', 'label' => 'Danh mục cha', 'rules' => 'trim'),
			array('field' => 'image', 'label' => 'Ảnh đại diện', 'rules' => 'trim'),
			array('field' => 'description', 'label' => 'Mô tả ngắn', 'rules' => 'trim'),
			array('field' => 'meta_title', 'label' => 'Meta title', 'rules' => 'trim'),
			array('field' => 'meta_keywords', 'label' => 'Meta keywords', 'rules' => 'trim'),
			array('field' => 'meta_description', 'label' => 'Meta description', 'rules' => 'trim'),		
		);
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$this->validation[] = array('field' => $key, 'label' => $val, 'rules' => 'trim');
			}
		}
	}

	// Đếm số danh mục
	public function count(){
		$param_where = NULL;
		$param_where['lang'] = $this->language;
		$keyword = $this->db->escape_like_str($this->input->get('keyword'));
		return $this->_general(array(
			'table' => $this->article_catalogue,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'count' => TRUE,
		));
	}

	// Danh sách danh mục
	public function show($limit = 0, $start = 0, $sort = NULL){
		$param_where = NULL;
		$param_where['lang'] = $this->language;
		$keyword = $this->db->escape_like_str($this->input->get('keyword'));
		$count_article = '(SELECT COUNT(id) FROM `article` WHERE `article`.`catalogueid` = `article_catalogue`.`id`) AS `count_article`';
		$email_created = '(SELECT `email` FROM `user` WHERE `article_catalogue`.`userid_created` = `user`.`id`) AS `email_created`';
		$sort['field'] = (isset($sort['field']) && !empty($sort['field']))?$sort['field']:'lft';
		$sort['sort'] = (isset($sort['sort']) && !empty($sort['sort']))?$sort['sort']:'ASC';
		return $this->_general(array(
			'select' => '*, '.$count_article.', '.$email_created,
			'table' => $this->article_catalogue,
			'limit' => $limit,
			'start' => ($start * $limit),
			'list' => TRUE,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'orderby' => $sort['field'].' '.$sort['sort']
		));
	}

	// Thông tin danh mục qua id
	public function get_byid($id = 0){
		$catalogue = $this->_getwhere(array(
			'select' => '*',
			'table' => $this->article_catalogue,
			'param_where' => array(
				'id' => $id,
			)
		));
		if(!isset($catalogue) || is_array($catalogue) == FALSE || count($catalogue) == 0){
			message_flash('Danh mục không tồn tại', 'error');
			redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
		}
		if($this->language != $catalogue['lang']){
			message_flash('Ngôn ngữ không phù hợp', 'error');
			redirect(!empty($this->redirect)?$this->redirect:'backend_article/catalogue/index');
		}
		return $catalogue;
	}
	
	// Thêm mới danh mục
	public function insert(){
		$data['title'] = $this->input->post('title');
		$data['slug'] = slug($data['title']);
		$data['canonical'] = slug($this->input->post('canonical'));
		$data['image'] = $this->input->post('image');
		$data['parentid'] = $this->input->post('parentid');
		$data['description'] = $this->input->post('description');
		$data['meta_title'] = $this->input->post('meta_title');
		$data['meta_keywords'] = $this->input->post('meta_keywords');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['userid_created'] = $this->authentication['id'];
		$data['lang'] = $this->language;
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$data[$key] = $this->input->post($key);
			}
		}
		return $this->_save(array(
			'table' => $this->article_catalogue,
			'data' => $data
		));
	}


	// Cập nhật danh mục qua id
	public function update_byid($id = 0){
		$data['title'] = $this->input->post('title');
		$data['slug'] = slug($data['title']);
		$data['canonical'] = slug($this->input->post('canonical'));
		$data['image'] = $this->input->post('image');
		$data['parentid'] = $this->input->post('parentid');
		$data['description'] = $this->input->post('description');
		$data['meta_title'] = $this->input->post('meta_title');
		$data['meta_keywords'] = $this->input->post('meta_keywords');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['userid_updated'] = $this->authentication['id'];
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$data[$key] = $this->input->post($key);
			}
		}
		return $this->_save(array(
			'table' => $this->article_catalogue,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}


	// Xóa danh mục qua id
	public function delete_byid($id = 0){
		return $this->_del(array(
			'table' => $this->article_catalogue,
			'param_where' => array(
				'id' => $id
			)
		));
	}

	// Cập nhật cấu hình danh mục qua id
	public function update_config_byid($id = 0, $data = NULL){
		return $this->_save(array(
			'table' => $this->article_catalogue,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}

}
