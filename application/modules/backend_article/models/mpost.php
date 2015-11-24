<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mpost extends My_Model{

	private $article = 'article';
	public $setconfig;
	public $validation;
	public $validation_leech;

	function __construct($params = NULL){
		parent::__construct();
		$this->validation = array(
			array('field' => 'title', 'label' => 'Tên bài viết', 'rules' => 'trim|required'),
			array('field' => 'canonical', 'label' => 'Canonical', 'rules' => 'trim'),	
			array('field' => 'source', 'label' => 'Nguồn', 'rules' => 'trim'),	
			array('field' => 'catalogueid', 'label' => 'Danh mục', 'rules' => 'trim|required|is_natural_no_zero'),
			array('field' => 'image', 'label' => 'Ảnh đại diện', 'rules' => 'trim'),
			array('field' => 'description', 'label' => 'Mô tả ngắn', 'rules' => 'trim|required'),
			array('field' => 'content', 'label' => 'Nội dung', 'rules' => 'trim|required'),
			array('field' => 'meta_title', 'label' => 'Meta title', 'rules' => 'trim'),
			array('field' => 'meta_keywords', 'label' => 'Meta keywords', 'rules' => 'trim'),
			array('field' => 'meta_description', 'label' => 'Meta description', 'rules' => 'trim'),	
		);
		$this->validation_leech = array(
			array('field' => 'title', 'label' => 'Tên bài viết', 'rules' => 'trim|required|callback__title'),
			array('field' => 'canonical', 'label' => 'Canonical', 'rules' => 'trim'),
			array('field' => 'catalogueid', 'label' => 'Danh mục', 'rules' => 'trim|required|is_natural_no_zero'),
			array('field' => 'image', 'label' => 'Ảnh đại diện', 'rules' => 'trim'),
			array('field' => 'description', 'label' => 'Mô tả ngắn', 'rules' => 'trim|required'),
			array('field' => 'content', 'label' => 'Nội dung', 'rules' => 'trim|required'),
			array('field' => 'meta_title', 'label' => 'Meta title', 'rules' => 'trim'),
			array('field' => 'meta_keywords', 'label' => 'Meta keywords', 'rules' => 'trim'),
			array('field' => 'meta_description', 'label' => 'Meta description', 'rules' => 'trim'),		
			array('field' => 'source', 'label' => 'Nguồn', 'rules' => 'trim|required|callback__source'),	
		);
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$this->validation[] = array('field' => $key, 'label' => $val, 'rules' => 'trim');
			}
		}
	}

	// Đếm số bài viết
	public function count(){
		$param_where = NULL;
		$param_where['lang'] = $this->language;
		$param_where['userid_created'] = $this->user['id'];
		$keyword = $this->db->escape_like_str($this->input->get('keyword'));
		$catalogueid = (int)$this->input->get('catalogueid');
		if($catalogueid > 0){
			$param_where['catalogueid'] = $catalogueid;
		}
		return $this->_general(array(
			'table' => $this->article,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'count' => TRUE,
		));
	}

	// Đếm số bài viết
	// public function count_bysource($source = ''){
		// $param_where = NULL;
		// $param_where['lang'] = $this->language;
		// $param_where['source'] = $source;
		// return $this->_general(array(
			// 'table' => $this->article,
			// 'param_where' => $param_where,
			// 'count' => TRUE,
		// ));
	// }

	// Danh sách bài viết
	public function show($limit = 0, $start = 0, $sort = NULL){
		$param_where = NULL;
		$param_where['lang'] = $this->language;
		$param_where['userid_created'] = $this->user['id'];

		$keyword = $this->db->escape_like_str($this->input->get('keyword'));
		$catalogueid = (int)$this->input->get('catalogueid');
		if($catalogueid > 0){
			$param_where['catalogueid'] = $catalogueid;
		}
		$catalogue_title = '(SELECT `title` FROM `article_catalogue` WHERE `article`.`catalogueid` = `article_catalogue`.`id`) AS `catalogue_title`';
		$email_created = '(SELECT `email` FROM `user` WHERE `article`.`userid_created` = `user`.`id`) AS `email_created`';
		$sort['field'] = (isset($sort['field']) && !empty($sort['field']))?$sort['field']:'id';
		$sort['sort'] = (isset($sort['sort']) && !empty($sort['sort']))?$sort['sort']:'DESC';
		return $this->_general(array(
			'select' => '*, '.$catalogue_title.', '.$email_created,
			'table' => $this->article,
			'limit' => $limit,
			'start' => ($start * $limit),
			'list' => TRUE,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'orderby' => $sort['field'].' '.$sort['sort']
		));
	}

	// Đếm số bài viết theo catalogueid
	public function count_bycatalogueid($catalogueid = 0){
		$param_where = NULL;
		$param_where['lang'] = $this->language;
		$param_where['catalogueid'] = $catalogueid;
		return $this->_general(array(
			'table' => $this->article,
			'param_where' => $param_where,
			'count' => TRUE,
		));
	}

	// Thông tin bài viết qua id
	public function get_byid($id = 0){
		$post = $this->_getwhere(array(
			'select' => '*',
			'table' => $this->article,
			'param_where' => array(
				'id' => $id,
			)
		));
		if(!isset($post) || is_array($post) == FALSE || count($post) == 0){
			message_flash('Bài viết không tồn tại', 'error');
			redirect(!empty($this->redirect)?$this->redirect:'backend_article/post/index');
		}
		if($this->language != $post['lang']){
			message_flash('Ngôn ngữ không phù hợp', 'error');
			redirect(!empty($this->redirect)?$this->redirect:'backend_article/post/index');
		}
		return $post;
	}


	// Cập nhật thông tin bài viết qua id
	public function update_byid($id = 0){
		$data['title'] = $this->input->post('title');
		$data['slug'] = slug($data['title']);
		$data['canonical'] = slug($this->input->post('canonical'));
		$data['catalogueid'] = $this->input->post('catalogueid');
		$data['image'] = $this->input->post('image');
		$data['description'] = $this->input->post('description');
		$data['content'] = $this->input->post('content');
		$data['source'] = $this->input->post('source');
		$data['meta_title'] = $this->input->post('meta_title');
		$data['meta_keywords'] = $this->input->post('meta_keywords');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['userid_updated'] = $this->user['id'];
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$data[$key] = $this->input->post($key);
			}
		}
		return $this->_save(array(
			'table' => $this->article,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}
	// Thêm mới
	public function insert(){
		$data['title'] = $this->input->post('title');
		$data['slug'] = slug($data['title']);
		$data['canonical'] = slug($this->input->post('canonical'));
		$data['image'] = $this->input->post('image');
		$data['catalogueid'] = $this->input->post('catalogueid');
		$data['description'] = $this->input->post('description');
		$data['content'] = $this->input->post('content');
		$data['source'] = $this->input->post('source');
		$data['meta_title'] = $this->input->post('meta_title');
		$data['meta_keywords'] = $this->input->post('meta_keywords');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['userid_created'] = $this->user['id'];
		$data['lang'] = $this->language;
		$data['publish']=1;
		return $this->_save(array(
			'table' => $this->article,
			'data' => $data
		));
	}

	// Cập nhật cấu hình bài viết qua id
	public function update_config_byid($id = 0, $data = NULL){
		return $this->_save(array(
			'table' => $this->article,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}

	// Đếm số bài viết qua title
	public function count_bytitle($title = ''){
		$count = $this->_getwhere(array(
			'table' => $this->article,
			'count' => TRUE,
			'param_where' => array(
				'title' => $title,
			)
		));
		return $count;
	}

	// Đếm số bài viết qua source
	public function count_bysource($source = ''){
		$count = $this->_getwhere(array(
			'table' => $this->article,
			'count' => TRUE,
			'param_where' => array(
				'source' => $source,
			)
		));
		return $count;
	}
	public function delete_byid($id = 0){
		return $this->_del(array(
			'table' => $this->article,
			'param_where' => array(
				'id' => $id
			)
		));
	}
}
