<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mconfig extends My_Model{

	private $system_config = 'system_config';
	public $setconfig;
	public $validation;

	function __construct($params = NULL){
		parent::__construct();
		$this->setconfig = array(
			'publish' => 'Xuất bản',
		);
		$this->validation = array(
			array('field' => 'title', 'label' => 'Tên vị trí', 'rules' => 'trim|required'),
			array('field' => 'keyword', 'label' => 'Từ khóa', 'rules' => 'trim|required'),
		);
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$this->validation[] = array('field' => $key, 'label' => $val, 'rules' => 'trim');
			}
		}
	}

	// Đếm số hệ thống
	public function count(){
		$param_where = NULL;
		$keyword = mysql_escape_string($this->input->get('keyword'));
		$positionid = $this->input->get('positionid');
		if($positionid > 0){
			$param_where['positionid'] = $positionid;
		}
		return $this->_general(array(
			'table' => $this->system_config,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\' OR `keyword` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'count' => TRUE,
		));
	}

	// Danh sách hệ thống
	public function show($limit = 0, $start = 0, $sort = NULL){
		$param_where = NULL;
		$keyword = mysql_escape_string($this->input->get('keyword'));
		$positionid = $this->input->get('positionid');
		if($positionid > 0){
			$param_where['positionid'] = $positionid;
		}
		$position_title = '(SELECT `title` FROM `system_position` WHERE `system_config`.`positionid` = `system_position`.`id`) AS `position_title`';
		$email_created = '(SELECT `email` FROM `user` WHERE `system_config`.`userid_created` = `user`.`id`) AS `email_created`';
		$sort['field'] = (isset($sort['field']) && !empty($sort['field']))?$sort['field']:'id';
		$sort['sort'] = (isset($sort['sort']) && !empty($sort['sort']))?$sort['sort']:'DESC';
		return $this->_general(array(
			'select' => '*, content_'.$this->language.' as content, '.$position_title.', '.$email_created,
			'table' => $this->system_config,
			'limit' => $limit,
			'start' => $start,
			'list' => TRUE,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\' OR `keyword` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'orderby' => $sort['field'].' '.$sort['sort']
		));
	}

	// Đếm số hệ thống qua positionid
	public function count_bypositionid($positionid = 0){
		$count = $this->_getwhere(array(
			'table' => $this->system_config,
			'count' => TRUE,
			'param_where' => array(
				'positionid' => $positionid,
			)
		));
		return $count;
	}
	
	// Dữ liệu hệ thống qua positionid
	public function show_bypositionid($positionid = 0){
		return $this->_getwhere(array(
			'select' => 'id, title, keyword, content_'.$this->language.' as content, type',
			'table' => $this->system_config,
			'param_where' => array('publish' => 1, 'positionid' => $positionid),
			'list' => TRUE,
			'orderby' => 'order ASC, id DESC'
		));
	}

	// Thông tin hệ thống qua id
	public function get_byid($id = 0){
		$config = $this->_getwhere(array(
			'select' => '*, content_'.$this->language.' as content',
			'table' => $this->system_config,
			'param_where' => array(
				'id' => $id,
			)
		));
		if(!isset($config) || is_array($config) == FALSE || count($config) == 0){
			message_flash('nhóm hệ thống không tồn tại', 'error');
			redirect('backend_system/config/index');
		}
		return $config;
	}

	// Đếm số hệ thống qua keyword
	public function count_bykeyword($keyword = ''){
		$keyword = slug($keyword);
		$count = $this->_getwhere(array(
			'table' => $this->system_config,
			'count' => TRUE,
			'param_where' => array(
				'keyword' => $keyword,
			)
		));
		return $count;
	}

	// Thêm mới hệ thống
	public function insert(){
		$data['title'] = $this->input->post('title');
		$data['keyword'] = slug($this->input->post('keyword'));
		$data['type'] = $this->input->post('type');
		$data['positionid'] = $this->input->post('positionid');
		$data['userid_created'] = $this->authentication['id'];
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$data[$key] = $this->input->post($key);
			}
		}
		return $this->_save(array(
			'table' => $this->system_config,
			'data' => $data
		));
	}

	// Cập nhật thông tin hệ thống qua id
	public function update_byid($id = 0){
		$data['title'] = $this->input->post('title');
		$data['keyword'] = slug($this->input->post('keyword'));
		$data['type'] = $this->input->post('type');
		$data['positionid'] = $this->input->post('positionid');
		$data['userid_updated'] = $this->authentication['id'];
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$data[$key] = $this->input->post($key);
			}
		}
		return $this->_save(array(
			'table' => $this->system_config,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}
	
	// Xóa hệ thống qua id
	public function delete_byid($id = 0){
		return $this->_del(array(
			'table' => $this->system_config,
			'param_where' =>array(
				'id' => $id
			),
		));
	}

	// Cập nhật cấu hình hệ thống qua id
	public function update_config_byid($id = 0, $data = NULL){
		return $this->_save(array(
			'table' => $this->system_config,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}
}
