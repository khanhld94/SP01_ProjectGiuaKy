<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MHome extends My_Model{

	private $system_position;
	private $user;

	function __construct(){
		parent::__construct();
		$this->system_position = 'system_position';
		$this->user = 'user';
		$this->article = 'article';
		$this->article_catalogue = 'article_catalogue';
	}

	// Cấu hình hệ thống
	public function listposition(){
		$param_where = NULL;
		$param_where['publish'] = 1;
		return $this->_getwhere(array(
			'select' => 'id, title, keyword, content_'.$this->language.' as content',
			'table' => $this->system_position,
			'param_where' => $param_where,
			'list' => TRUE,
			'orderby' => 'order ASC, id DESC'
		));
	}
	
	// Lấy thông tin tài khoản thông qua mã tài khoản
	public function get_user_byid($id = 0){
		$param_where = NULL;
		$param_where['id'] = $id;
		$user = $this->_getwhere(array(
			'select' => 'id, email, fullname',
			'table' => $this->user,
			'param_where' => $param_where
		));
		if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
			message_flash('Tài khoản không tồn tại', 'error');
			redirect(site_url());
		}
		return $user;
	}
	// Đếm số bài viết
	public function count($created = NULL){
		$param_where = NULL;
		//$param_where['created'] = isset($created)? $created : NULL;
		if(isset($created))
			$param_where['userid_created'] = $created; 
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

	public function show($limit = 0, $start = 0, $sort = NULL,$created = NULL){
		$param_where = NULL;
		$keyword = $this->db->escape_like_str($this->input->get('keyword'));
		$catalogueid = (int)$this->input->get('catalogueid');
		if($catalogueid > 0){
			$param_where['catalogueid'] = $catalogueid;
		}
		if($created != NULL){
			$param_where['userid_created'] = $created;
		}
		$catalogue_title = '(SELECT `title` FROM `article_catalogue` WHERE `article`.`catalogueid` = `article_catalogue`.`id`) AS `catalogue_title`';
		$email_created = '(SELECT `email` FROM `user` WHERE `article`.`userid_created` = `user`.`id`) AS `email_created`';
		return $this->_general(array(
			'select' => 'title,id,created,image,canonical,slug,'.$catalogue_title.', '.$email_created,
			'table' => $this->article,
			'limit' => $limit,
			'start' => ($start * $limit),
			'list' => TRUE,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'orderby' => 'created DESC'
		));
	}
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
	//manager
	public function insert($notification = NULL){
		if(isset($notification)&&is_array($notification)&&count($notification))
		$data=$notification;
		return $this->_save(array(
			'table' => 'notifi',
			'data' => $data
		));
	}

	public function notifi(){
		$param_where['UserRe'] = $this->authentication['id'];
		$param_where['TT2'] = 0;
		return $this->_general(array(
			'select' => 'UserSend,UserRe,ID1,ID2',
			'table' => 'notifi',
			'param_where' => $param_where,
			'orderby' => 'created DESC',
			'list' => TRUE,
			));
	}
}
