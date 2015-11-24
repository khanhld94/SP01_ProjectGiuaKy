<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MSystem extends My_Model{

	private $system_position = 'system_position';
	private $system_config = 'system_config';

	function __construct(){
		parent::__construct();
	}
	
	// Danh sách vị trí hệ thống
	public function listposition(){
		return $this->_getwhere(array(
			'select' => 'id, title, keyword, content_'.$this->language.' as content',
			'table' => $this->system_position,
			'param_where' => array('publish' => 1),
			'list' => TRUE,
			'orderby' => 'order ASC, id DESC'
		));
	}
	
	// Danh sách hệ thống
	public function listconfig(){
		return $this->_getwhere(array(
			'select' => 'id, title, keyword, content_'.$this->language.' as content',
			'table' => $this->system_config,
			'param_where' => array('publish' => 1),
			'list' => TRUE,
			'orderby' => 'order ASC, id DESC'
		));
	}

	// Danh sách hệ thống theo vị trí
	public function listconfig_bypositionid($positionid = 0){
		return $this->_getwhere(array(
			'select' => 'id, title, keyword, content_'.$this->language.' as content, type',
			'table' => $this->system_config,
			'param_where' => array('publish' => 1, 'positionid' => $positionid),
			'list' => TRUE,
			'orderby' => 'order ASC, id DESC'
		));
	}

	// Cập nhật cấu hình hệ thống
	public function update(){
		$config = $this->input->post('config');
		if(isset($config) && is_array($config) && count($config)){
			$data = NULL;
			foreach($config as $key => $val){
				$data[] = array(
					'keyword' => $key,
					'content_'.$this->language => $val
				);
			}
			return $this->_savebatch(array(
				'table' => $this->system_config,
				'data' => $data,
				'field' => 'keyword'
			));
		}
		return 0;
	}

}
