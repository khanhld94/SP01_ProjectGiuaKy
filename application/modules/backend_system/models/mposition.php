<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mposition extends My_Model{

	private $system_position = 'system_position';
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

	// Đếm số vị trí hệ thống
	public function count(){
		$param_where = NULL;
		return $this->_general(array(
			'table' => $this->system_position,
			'param_where' => $param_where,
			'count' => TRUE,
		));
	}

	// Danh sách vị trí hệ thống
	public function show($limit = 0, $start = 0, $sort = NULL){
		$param_where = NULL;
		$keyword = mysql_real_escape_string($this->input->get('keyword'));
		$count_config = '(SELECT COUNT(id) FROM `system_config` WHERE `system_config`.`positionid` = `system_position`.`id`) AS `count_config`';
		$email_created = '(SELECT `email` FROM `user` WHERE `system_position`.`userid_created` = `user`.`id`) AS `email_created`';
		$sort['field'] = (isset($sort['field']) && !empty($sort['field']))?$sort['field']:'id';
		$sort['sort'] = (isset($sort['sort']) && !empty($sort['sort']))?$sort['sort']:'DESC';
		return $this->_general(array(
			'select' => '*, content_'.$this->language.' as content, '.$count_config.', '.$email_created,
			'table' => $this->system_position,
			'limit' => $limit,
			'start' => $start,
			'list' => TRUE,
			'param' => (!empty($keyword)?'(`title` LIKE \'%'.$keyword.'%\')':''),
			'param_where' => $param_where,
			'orderby' => $sort['field'].' '.$sort['sort']
		));
	}

	// Đếm số vị trí hệ thống qua keyword
	public function count_bykeyword($keyword = ''){
		$keyword = slug($keyword);
		$count = $this->_getwhere(array(
			'table' => $this->system_position,
			'count' => TRUE,
			'param_where' => array(
				'keyword' => $keyword,
			)
		));
		return $count;
	}

	// Thêm mới vị trí hệ thống
	public function insert(){
		$data['title'] = $this->input->post('title');
		$data['keyword'] = slug($this->input->post('keyword'));
		$data['content_'.$this->language] = $this->input->post('content');
		$data['userid_created'] = $this->authentication['id'];
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$data[$key] = $this->input->post($key);
			}
		}
		return $this->_save(array(
			'table' => $this->system_position,
			'data' => $data
		));
	}

	// Thông tin vị trí hệ thống qua id
	public function get_byid($id = 0){
		$position = $this->_getwhere(array(
			'select' => '*, content_'.$this->language.' as content',
			'table' => $this->system_position,
			'param_where' => array(
				'id' => $id,
			)
		));
		if(!isset($position) || is_array($position) == FALSE || count($position) == 0){
			message_flash('Vị trí hệ thống không tồn tại', 'error');
			redirect('backend_system/position/index');
		}
		return $position;
	}

	// Cập nhật thông tin vị trí hệ thống qua id
	public function update_byid($id = 0){
		$data['title'] = $this->input->post('title');
		$data['keyword'] = slug($this->input->post('keyword'));
		$data['content_'.$this->language] = $this->input->post('content');
		$data['userid_updated'] = $this->authentication['id'];
		if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){
			foreach($this->setconfig as $key => $val){
				$data[$key] = $this->input->post($key);
			}
		}
		return $this->_save(array(
			'table' => $this->system_position,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}

	// Cập nhật cấu hình vị trí hệ thống qua id
	public function update_config_byid($id = 0, $data = NULL){
		return $this->_save(array(
			'table' => $this->system_position,
			'data' => $data,
			'param_where' => array(
				'id' => $id
			)
		));
	}
	
	// Xóa vị trí hệ thống qua id
	public function delete_byid($id = 0){
		return $this->_del(array(
			'table' => $this->system_position,
			'param_where' =>array(
				'id' => $id
			),
		));
	}

	// Vị trí hệ thống dropdown
	public function dropdown($param = NULL){
		$list[0] = '- Chọn vị trí -';
		$data = $this->_getwhere(array(
			'select' => 'id, title',
			'table' => $this->system_position,
			'param_where' => array('publish' => 1),
			'list' => TRUE,
			'orderby' => 'title DESC'
		));
		if(isset($data) && is_array($data) && count($data)){
			foreach($data as $key => $val){
				$list[$val['id']] = $val['title'];
			}
		}
		return $list;
	}
}
