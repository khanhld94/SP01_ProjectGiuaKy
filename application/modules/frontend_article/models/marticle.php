<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MArticle extends My_Model{

	private $article_catalogue;
	private $article;

	function __construct(){
		parent::__construct();
		$this->article_catalogue = 'article_catalogue';
		$this->article = 'article';
	}

	// Bài viết mới nhất
	public function list_newpost($limit = 5){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		return $this->_getwhere(array(
			'select' => 'id, title, slug, canonical',
			'table' => $this->article,
			'param_where' => $param_where,
			'limit' => $limit,
			'list' => TRUE,
			'orderby' => 'id DESC'
		));
	}
	public function list_allpost($limit=5,$start =0){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		return $this->_getwhere(array(
			'select' => 'id, title, slug, canonical,image,description,created',
			'table' => $this->article,
			'param_where' => $param_where,
			'list' => TRUE,
			'limit' => $limit,
			'start' => ($start * $limit),
			'orderby' => 'created DESC'
		));
	}
	public function count_allpost()
	{
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		return $this->_getwhere(array(
				'table' => $this->article,
				'param_where' => $param_where,
				'count' => TRUE,
			));
	}
	// Bài viết nổi bật
	public function list_highlightpost($limit = 5){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['highlight'] = 1;
		$param_where['lang'] = $this->language;
		return $this->_getwhere(array(
			'select' => 'id, title, slug, canonical,image, description,created',
			'table' => $this->article,
			'param_where' => $param_where,
			'limit' => $limit,
			'list' => TRUE,
			'orderby' => 'order ASC, id ASC'
		));
	}
	// Danh mục nổi bật
	public function list_highlightcatalogue(){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['highlight'] = 1;
		$param_where['lang'] = $this->language;
		return $this->_getwhere(array(
			'select' => 'id, title, slug, canonical, lft, rgt',
			'table' => $this->article_catalogue,
			'param_where' => $param_where,
			'list' => TRUE,
			'orderby' => 'id DESC'
		));
	}

	// Danh mục nổi bật
	public function list_catalogue_byparentid($parentid = 0){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['parentid'] = $parentid;
		$param_where['lang'] = $this->language;
		return $this->_getwhere(array(
			'select' => 'id, title, slug, canonical',
			'table' => $this->article_catalogue,
			'param_where' => $param_where,
			'list' => TRUE,
			'orderby' => 'lft ASC'
		));
	}

	// Bài viết theo danh mục
	public function list_post_bycatalogueid($catalogueid = 0, $children = NULL, $limit = 10){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		if(isset($children) && is_array($children) && count($children)){
			return $this->_general(array(
				'select' => 'id, title, slug, canonical, image, description,created',
				'table' => $this->article,
				'param_where' => $param_where,
				'limit' => $limit,
				'field_where_in' => 'catalogueid',
				'param_where_in' => $children,
				'list' => TRUE,
				'orderby' => 'order DESC, id DESC'
			));
		}
		else{
			$param_where['catalogueid'] = $catalogueid;
			return $this->_getwhere(array(
				'select' => 'id, title, slug, canonical, image, description,created',
				'table' => $this->article,
				'param_where' => $param_where,
				'limit' => $limit,
				'list' => TRUE,
				'orderby' => 'order DESC, id DESC'
			));
		}
	}

	// Thông tin bài viết theo mã bài viết
	public function get_post_byid($id = 0,$userid_created=NULL){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		if($userid_created!=NULL)
			$param_where['userid_created'] = $userid_created;
		$param_where['id'] = $id;
		$post = $this->_getwhere(array(
			'select' => '*',
			'table' => $this->article,
			'param_where' => $param_where
		));
		if(!isset($post) || is_array($post) == FALSE || count($post) == 0){
			message_flash('Bài viết không tồn tại', 'error');
			redirect(site_url());
		}
		if($this->language != $post['lang']){
			message_flash('Ngôn ngữ không phù hợp', 'error');
			redirect(site_url());
		}
		return $post;
	}


	// Thông tin danh mục theo mã danh mục
	public function get_catalogue_byid($id = 0){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		$param_where['id'] = $id;
		$catalogue = $this->_getwhere(array(
			'select' => '*',
			'table' => $this->article_catalogue,
			'param_where' => $param_where
		));
		if(!isset($catalogue) || is_array($catalogue) == FALSE || count($catalogue) == 0){
			message_flash('Danh mục không tồn tại', 'error');
			redirect(site_url());
		}
		if($this->language != $catalogue['lang']){
			message_flash('Ngôn ngữ không phù hợp', 'error');
			redirect(site_url());
		}
		return $catalogue;
	}

	// Đếm số bài viết theo danh mục
	public function count_post($catalogueid = 0, $children = NULL){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		if(isset($children) && is_array($children) && count($children)){
			return $this->_general(array(
				'table' => $this->article,
				'param_where' => $param_where,
				'field_where_in' => 'catalogueid',
				'param_where_in' => $children,
				'count' => TRUE,
			));
		}
		else{
			$param_where['catalogueid'] = $catalogueid;
			return $this->_getwhere(array(
				'table' => $this->article,
				'param_where' => $param_where,
				'count' => TRUE,
			));
		}
	}

	// Bài viết theo danh mục
	public function list_post($catalogueid = 0, $children = NULL, $limit = 0, $start = 0){
		$param_where = NULL;
		$param_where['publish'] = 1;
		$param_where['lang'] = $this->language;
		if(isset($children) && is_array($children) && count($children)){
			return $this->_general(array(
				'select' => 'id, title, slug, canonical, image, description, created',
				'table' => $this->article,
				'param_where' => $param_where,
				'field_where_in' => 'catalogueid',
				'param_where_in' => $children,
				'limit' => $limit,
				'start' => ($start * $limit),
				'list' => TRUE,
				'orderby' => 'order DESC, id DESC'
			));
		}
		else{
			$param_where['catalogueid'] = $catalogueid;
			return $this->_getwhere(array(
				'select' => 'id, title, slug, canonical, image, description, created',
				'table' => $this->article,
				'param_where' => $param_where,
				'limit' => $limit,
				'start' => ($start * $limit),
				'list' => TRUE,
				'orderby' => 'order DESC, id DESC'
			));
		}
	}
	
	// Bài viết cùng chuyên mục
	public function list_post_same($catalogueid, $id, $limit = 5){
		$param_where = NULL;
		$param_where['lang'] = $this->language;
		$param_where['publish'] = 1;
		$param_where['catalogueid'] = $catalogueid;
		$param_where['id !='] = $id;
		return $this->_general(array(
			'select' => 'id, title, slug, canonical, image, created',
			'table' => $this->article,
			'param_where' => $param_where,
			'limit' => $limit,
			'list' => TRUE,
			'orderby' => 'order DESC, id DESC'
		));
	}
	public function search($catalogueid,$string){

		$param_where = NULL;
		$param_where['lang'] = $this->language;
		$param_where['publish'] = 1;
		if($catalogueid !=0) $param_where['catalogueid'] = $catalogueid;
		$param_where['title like'] = '%'.$string.'%';
		return $this->_general(array(
			'select' => 'id, title, slug, canonical, image, created',
			'table' => $this->article,
			'param_where' => $param_where,
			'limit' => $limit,
			'list' => TRUE,
			'orderby' => 'order DESC, id DESC'

		));	
	}
}
