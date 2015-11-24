<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Muser extends My_Model{

	private $user = 'user';
	public $validation;
	public $validation_update;
	public $validation_reset;

	function __construct(){
		parent::__construct();
		$this->validation = array(
			array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|callback__checkemail'),
			array('field' => 'fullname', 'label' => 'Tên đầy đủ', 'rules' => 'trim|required'),
			//array('field' => 'avatar', 'label' => 'Avatar', 'rules' => 'trim'),
			//array('field' => 'groupid', 'label' => 'Nhóm thành viên', 'rules' => 'trim|required|is_natural_no_zero'),
			array('field' => 'password', 'label' => 'Mật khẩu', 'rules' => 'trim|required|min_length[6]|max_length[255]'),
			array('field' => 'repassword', 'label' => 'Gõ lại Mật khẩu', 'rules' => 'trim|required|min_length[6]|max_length[255]|matches[password]'),
		);
		$this->validation_update = array(
			array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
			array('field' => 'avatar', 'label' => 'Avatar', 'rules' => 'trim'),
			array('field' => 'fullname', 'label' => 'Tên đầy đủ', 'rules' => 'trim'),
			array('field' => 'groupid', 'label' => 'Nhóm thành viên', 'rules' => 'trim|required|is_natural_no_zero'),
		);
		$this->validation_reset = array(
			array('field' => 'password', 'label' => 'Mật khẩu', 'rules' => 'trim|required|min_length[6]|max_length[255]'),
			array('field' => 'repassword', 'label' => 'Gõ lại Mật khẩu', 'rules' => 'trim|required|min_length[6]|max_length[255]|matches[password]'),
		);
	}

	// Đếm số thành viên
	public function count(){
		$param_where = NULL;
		$groupid = (int)$this->input->get('groupid');
		$keyword = mysql_real_escape_string($this->input->get('keyword'));
		if($groupid > 0){
			$param_where['groupid'] = $groupid;
		}
		return $this->_general(array(
			'table' => $this->user,
			'count' => TRUE,
			'param' => (!empty($keyword)?'(`email` LIKE \'%'.$keyword.'%\' OR `fullname` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where
		));
	}

	// Danh sách thành viên
	public function show($limit = 0, $start = 0, $sort = NULL){
		$param_where = NULL;
		$groupid = (int)$this->input->get('groupid');
		$keyword = mysql_real_escape_string($this->input->get('keyword'));
		if($groupid > 0){
			$param_where['groupid'] = $groupid;
		}
		$group_title = '(SELECT `title` FROM `user_group` WHERE `user`.`groupid` = `user_group`.`id`) AS `group_title`';
		$sort['field'] = (isset($sort['field']) && !empty($sort['field']))?$sort['field']:'id';
		$sort['sort'] = (isset($sort['sort']) && !empty($sort['sort']))?$sort['sort']:'DESC';
		return $this->_general(array(
			'select' => '*, '.$group_title,
			'table' => $this->user,
			'limit' => $limit,
			'start' => $start,
			'list' => TRUE,
			'param' => (!empty($keyword)?'(`email` LIKE \'%'.$keyword.'%\' OR `fullname` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'orderby' => $sort['field'].' '.$sort['sort']
		));
	}

	// Đếm số thành viên qua groupid
	public function count_bygroupid($groupid = 0){
		$count = $this->_getwhere(array(
			'table' => $this->user,
			'count' => TRUE,
			'param_where' => array(
				'groupid' => $groupid,
			)
		));
		return $count;
	}

	// Thêm mới thành viên
	public function insert(){
		$salt = random();
		return $this->_save(array(
			'table' => $this->user,
			'data' => array(
				'email' => $this->input->post('email'),
				'fullname' => $this->input->post('fullname'),
				'salt' => $salt,
				'password' => encryption($this->input->post('password'), $salt),
				'mobile' => $this->input->post('mobile'),
				'groupid'=> 2,
				'avatar' => $this->input->post('avatar'),
			)
		));
	}

	// Thông tin thành viên qua id
	public function get_byid($id = 0){
		$user = $this->_getwhere(array(
			'table' => $this->user,
			'param_where' => array(
				'id' => $id,
			)
		));
		if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
			message_flash('Thành viên không tồn tại', 'error');
			redirect('backend_user/user/index');
		}
		return $user;
	}

	// Đếm số thành viên qua email
	public function count_byemail($email = ''){
		$count = $this->_getwhere(array(
			'table' => $this->user,
			'count' => TRUE,
			'param_where' => array(
				'email' => $email,
			)
		));
		return $count;
	}
	
	// Cập nhật thông tin nhóm quyền qua id
	public function update_byid($id = 0){
		return $this->_save(array(
			'table' => $this->user,
			'data' => array(
				'email' => $this->input->post('email'),
				'fullname' => $this->input->post('fullname'),
				'avatar' => $this->input->post('avatar'),
				'groupid' => $this->input->post('groupid'),
				'userid_updated' => $this->authentication['id']
			),
			'param_where' => array(
				'id' => $id
			)
		));
	}
	
	// Cập nhật thông tin nhóm quyền qua id
	public function reset_byid($id = 0){
		$salt = random();
		return $this->_save(array(
			'table' => $this->user,
			'data' => array(
				'salt' => $salt,
				'password' => encryption($this->input->post('password'), $salt),
			),
			'param_where' => array(
				'id' => $id
			)
		));
	}

	// Xóa thành viên qua id
	public function delete_byid($id = 0){
		return $this->_del(array(
			'table' => $this->user,
			'param_where' =>array(
				'id' => $id
			),
		));
	}

	// Dropdown thành viên
	public function dropdown(){
		$group = $this->_get(array(
			'select' => 'id, title',
			'table' => 'user_group',
			'list' => TRUE
		));
		$user = $this->_get(array(
			'select' => 'id, email, fullname',
			'table' => $this->user,
			'list' => TRUE
		));
		$dropdown[] = '- Nhân viên -';
		if(isset($group) && is_array($group) && count($group)){
			foreach($group as $keyGroup => $valGroup){
				$temp = NULL;
				foreach($user as $keyUser => $valUser){
					$temp[$valUser['id']] = $valUser['fullname'].' - '.$valUser['email'];
				}
				$dropdown[$valGroup['title']] = $temp;
			}
		}
		return $dropdown;
	}

}
