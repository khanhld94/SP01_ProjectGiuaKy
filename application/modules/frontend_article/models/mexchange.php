<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MExchange extends My_Model{

	private $article_catalogue;
	private $article;

	function __construct(){
		parent::__construct();
		$this->article_catalogue = 'article_catalogue';
		$this->article = 'notifi';
	}
	public function check_exchange($id = 0)
	{
		$param_where = NULL;
		$param_where['ID1'] = 0;//$id;
		$param_where['TT2'] = 0;
		return $this->_general(array(
			'select' => '*',
			'table' => $this->article,
			'param_where' => $param_where,
			'count' => TRUE
		));
	}
	
}
