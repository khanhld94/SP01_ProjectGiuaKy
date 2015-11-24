<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MRouter extends My_Model{

	private $router = 'router';

	function __construct(){
		parent::__construct();
	}
	
	// Thông tin router qua slug
	public function get_byslug($slug = ''){
		return $this->_getwhere(array(
			'table' => $this->router,
			'count' => TRUE,
			'param_where' => array('slug' => $slug)
		));
	}
	
	// Thêm mới router
	public function insert($data){
		return $this->_save(array(
			'table' => $this->router,
			'data' => $data
		));
	}
	
	// Cập nhật router thông qua slug
	public function update_byslug($slug = '', $data = NULL){
		return $this->_save(array(
			'table' => $this->router,
			'data' => $data,
			'param_where' =>array(
				'slug' => $slug,
			)
		));
	}
	
	// Xóa router qua slug
	public function delete_byslug($slug = ''){
		return $this->_del(array(
			'table' => $this->router,
			'param_where' => array(
				'slug' => $slug,
			),
		));	
	}
	
	// Xóa router qua module
	public function delete_bymod($param_where = NULL){
		return $this->_del(array(
			'table' => $this->router,
			'param_where' => $param_where
		));	
	}
	
	// Xóa router
	public function delete($param = NULL){
		return $this->_del(array(
			'table' => $this->router,
			'param_where' => $param['param_where'],
			'field_where_in' => $param['field_where_in'],
			'param_where_in' => $param['param_where_in']
		));
	}

}
