<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mgroup extends My_Model{

	private $user_group = 'user_group';
	public $validation;

	function __construct(){
		parent::__construct();
		$this->validation = array(
			array('field' => 'title', 'label' => 'Tên nhóm quyền', 'rules' => 'trim|required'),
		);
	}

	// Đếm số nhóm quyền
	public function count(){
		$param_where = NULL;
		$keyword = mysql_real_escape_string($this->input->get('keyword'));
		return $this->_general(array(
			'table' => $this->user_group,
			'count' => TRUE,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where
		));
	}

	// Danh sách nhóm quyền
	public function show($limit = 0, $start = 0, $sort = NULL){
		$param_where = NULL;
		$keyword = mysql_real_escape_string($this->input->get('keyword'));
		$count_user = '(SELECT COUNT(id) FROM `user` WHERE `user`.`groupid` = `user_group`.`id`) AS `count_user`';
		$sort['field'] = (isset($sort['field']) && !empty($sort['field']))?$sort['field']:'id';
		$sort['sort'] = (isset($sort['sort']) && !empty($sort['sort']))?$sort['sort']:'DESC';
		return $this->_general(array(
			'select' => '*, '.$count_user,
			'table' => $this->user_group,
			'limit' => $limit,
			'start' => $start,
			'list' => TRUE,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'orderby' => $sort['field'].' '.$sort['sort']
		));
	}

	// Thêm mới nhóm quyền
	public function insert(){
		$group = '';
		$permissions = $this->input->post('permissions');
		if(isset($permissions) && is_array($permissions) && count($permissions)){
			$group = json_encode($permissions);
		}
		return $this->_save(array(
			'table' => $this->user_group,
			'data' => array(
				'title' => $this->input->post('title'),
				'group' => $group,
				'userid_created' => $this->authentication['id']
			)
		));
	}

	// Thông tin nhóm quyền qua id
	public function get_byid($id = 0){
		$group = $this->_getwhere(array(
			'table' => $this->user_group,
			'param_where' => array(
				'id' => $id,
			)
		));
		if(!isset($group) || is_array($group) == FALSE || count($group) == 0){
			message_flash('Nhóm quyền không tồn tại', 'error');
			redirect('backend_user/group/index');
		}
		return $group;
	}

	// Thông tin nhóm quyền qua title
	public function get_bytitle($title = ''){
		$group = $this->_getwhere(array(
			'table' => $this->user_group,
			'param_where' => array(
				'title' => $title,
			)
		));
		if(!isset($group) || is_array($group) == FALSE || count($group) == 0){
			message_flash('Nhóm quyền không tồn tại', 'error');
			redirect('backend_user/group/index');
		}
		return $group;
	}

	// Đếm số nhóm quyền qua title
	public function count_bytitle($title = ''){
		$count = $this->_getwhere(array(
			'table' => $this->user_group,
			'count' => TRUE,
			'param_where' => array(
				'title' => $title,
			)
		));
		return $count;
	}
	
	// Cập nhật thông tin nhóm quyền qua id
	public function update_byid($id = 0){
		$group = '';
		$permissions = $this->input->post('permissions');
		if(isset($permissions) && is_array($permissions) && count($permissions)){
			$group = json_encode($permissions);
		}
		return $this->_save(array(
			'table' => $this->user_group,
			'data' => array(
				'title' => $this->input->post('title'),
				'group' => $group,
				'userid_updated' => $this->authentication['id']
			),
			'param_where' => array(
				'id' => $id
			)
		));
	}
	
	// Xóa nhóm quyền qua id
	public function delete_byid($id = 0){
		return $this->_del(array(
			'table' => $this->user_group,
			'param_where' =>array(
				'id' => $id
			),
		));
	}

	// Cập nhật cấu hình nhóm quyền qua id
	public function update_config_byid($id = 0, $data = NULL){
		return $this->_save(array(
			'table' => $this->user_group,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}

	// Cập nhật cấu hình nhóm quyền qua update_config_byparam
	public function update_config_byparam($param_where = NULL, $data = NULL){
		return $this->_save(array(
			'table' => $this->user_group,
			'data' => $data,
			'param_where' => $param_where
		));
	}

	// Dropdown nhóm quyền
	public function dropdown(){
		$group = $this->_get(array(
			'select' => 'id, title',
			'table' => $this->user_group,
			'list' => TRUE
		));
		$dropdown[] = '- Nhóm thành viên -';
		if(isset($group) && is_array($group) && count($group)){
			foreach($group as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}

}
