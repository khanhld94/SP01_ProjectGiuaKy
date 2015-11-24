<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('get_thumb')){
	function get_thumb($image = ''){
		$image = !empty($image)?$image:'template/thumbnail-default.jpg';
		$image_thumb = str_replace('/image/', '/.thumbs/image/', $image);
		if (file_exists(dirname(dirname(dirname(__FILE__))).$image_thumb)){
			return $image_thumb;
		}
		return $image;
	}
}

/*---------------------------
 * Tạo câu thông báo đơn giản
 */
if(!function_exists('message_flash')){
	function message_flash($message = '', $type = 'successful'){
		$CI =& get_instance();
		$CI->session->set_flashdata('message_flashdata', array(
			'type' => $type,
			'message' => $message
		));
	}
}

/*---------------------------
 * Tạo ra giá trị sort, nếu không tồn tại sẽ lấy mặc định id desc
 * Mục đích phục vụ cho controller khi lấy về giá trị cần sort
 */
if(!function_exists('sort_field')){
	function sort_field($field, $sort){
		return (!isset($field) || empty($field) || !isset($sort) || empty($sort)) ? array(
			'field' => 'id',
			'sort' => 'desc'
		):array(
			'field' => $field,
			'sort' => $sort
		);
	}
}

/*---------------------------
 * Tạo ra link sort
 */
if(!function_exists('sort_general')){
	function sort_general($param, $config, $sort = NULL){
		if(!isset($sort)) return '<a href="'.$config['base_url'].'" title="'.htmlspecialchars($param['title']).'">'.$param['title'].'</a>';
		$url = $config['base_url'].(($config['cur_page'] > 1)?'/'.$config['cur_page']:'').$config['param'].'&';
		if(isset($param) && count($param)){
			foreach($param as $key => $val){
				if(in_array($key, array('title'))) continue;
				$url = $url.$key.'='.urlencode($val).'&';
			}
		}
		$flag = 0;
		if($param['field'] == $sort['field']){
			$sort['sort'] = ($sort['sort'] == 'asc')?'desc':'asc';
			$flag = 1;
		}
		else{
			$sort['sort'] = 'desc';
		}
		$url = $url.'sort='.$sort['sort'];
		$arrow = ($flag == 1)?($sort['sort'] == 'desc')?'<img src="template/backend/default/images/asc.png" alt="asc" title="asc" />':'<img src="template/backend/default/images/desc.png" alt="desc" title="desc" />':'';
		return '<a href="'.$url.'" title="'.htmlspecialchars($param['title']).'">'.$param['title'].$arrow.'</a>';
	}
}

/*---------------------------
 * Tạo ra giá trị sort, nếu không tồn tại sẽ lấy mặc định id desc
 * Mục đích phục vụ cho controller khi lấy về giá trị cần sort
 */
if(!function_exists('show_time')){
	function show_time($time, $type = 'H:i - d/m/Y'){
		return gmdate($type, strtotime($time));
	}
}

/*---------------------------
 * Nối cấu hình
 */
if(!function_exists('str_setconfig')){
	function str_setconfig($setconfig = NULL, $array = FALSE){
		$str = '';
		if(isset($setconfig) && is_array($setconfig) && count($setconfig)){
			foreach($setconfig as $key => $val){
				if($array == TRUE){
					$str[] = $key;
				}
				else{
					$str = $str.$key.', ';
				}
			}
		}
		return $str;
	}
}


if(!function_exists('cutnchar')){
	function cutnchar($str = NULL, $n = 0){
		if(strlen($str) < $n) return $str;
		$html = substr($str, 0, $n);
		$html = substr($html, 0, strrpos($html,' '));
		return $html.'...';
	}
}

/*---------------------------
 * Xử lý lang mặc định
 */
if(!function_exists('language_current')){
	function language_current(){
		$CI =& get_instance();
		$language_current = $CI->session->userdata('language_current');
		if(!isset($language_current) || empty($language_current)){	/* Kiểm tra tồn tại lang */
			$CI->session->set_userdata('language_current', LANGUAGE_DEFAULT);
			return LANGUAGE_DEFAULT;	/* Lấy lang default */
		}
		else{
			$language_list = $CI->config->item('language_list');	/* Kiểm tra ang có trong danh sách */
			if(!isset($language_list[$language_current])){
				$CI->session->set_userdata('language_current', LANGUAGE_DEFAULT);
				return LANGUAGE_DEFAULT;	/* Lấy lang default */
			}
			return $language_current;
		}
	}
}

if(!function_exists('lang')){
	function lang($str = '', $return = FALSE){
		$CI =& get_instance();
		$lang = $CI->lang->line($str);
		if($return == TRUE){
			return !empty($lang)?$lang:$str;
		}
		else{
			echo !empty($lang)?$lang:$str;
		}
		
	}
}

if(!function_exists('random')){
	function random($leng = 168, $char = FALSE){
		if($char == FALSE) $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
		else $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		mt_srand((double)microtime() * 1000000);
		$salt = '';
		for ($i=0; $i<$leng; $i++){
			$salt = $salt . substr($s, (mt_rand()%(strlen($s))), 1);
		}
		return $salt;
	}
}

if(!function_exists('encryption')){
	function encryption($pasword = '', $salt = ''){
		return md5(md5($pasword).md5($salt));
	}
}

if(!function_exists('mail_html')){
	function mail_html($param = NULL){
		return '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><div style="margin:0;padding:0" dir="ltr"><table width="98%" border="0" cellspacing="0" cellpadding="40"><tbody><tr><td bgcolor="#f7f7f7" width="100%" style="font-family:\'lucida grande\',tahoma,verdana,arial,sans-serif"><table cellpadding="0" cellspacing="0" border="0" width="620"><tbody><tr><td style="background:#3b5998;color:#ffffff;font-weight:bold;font-family:\'lucida grande\',tahoma,verdana,arial,sans-serif;vertical-align:middle;padding:4px 8px;font-size:16px;letter-spacing:-0.03em;text-align:left">'.(isset($param['header'])?$param['header']:'Biegr.com').'</td><td style="background:#3b5998;color:#ffffff;font-weight:bold;font-family:\'lucida grande\',tahoma,verdana,arial,sans-serif;vertical-align:middle;padding:4px 8px;font-size:11px;text-align:right"></td></tr><tr><td colspan="2" style="background-color:#ffffff;border-bottom:1px solid #3b5998;border-left:1px solid #cccccc;border-right:1px solid #cccccc;padding:15px;font-family:\'lucida grande\',tahoma,verdana,arial,sans-serif" valign="top"><table width="100%" cellpadding="0" cellspacing="0"><tbody><tr><td width="100%" style="font-size:12px" valign="top" align="left"><div style="margin-bottom:15px;font-size:12px;font-family:\'lucida grande\',tahoma,verdana,arial,sans-serif">'.(isset($param['greet'])?$param['greet']:'Chào bạn').',</div><div style="margin-bottom: 0px;">'.(isset($param['description'])?$param['description']:'Mô tả:').'</div></td></tr></tbody></table><br><table cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:100%"><tbody><tr><td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:10px;background-color:#fff9d7;border-left:1px solid #e2c822;border-right:1px solid #e2c822;border-top:1px solid #e2c822;border-bottom:1px solid #e2c822"><div style="font-weight:bold;margin-bottom:2px;font-size:11px">'.(isset($param['content'])?$param['content']:'Nội dung:').'</div>'.(isset($param['link'])?$param['link']:'').'</td></tr></tbody></table></td></tr><tr><td colspan="2" style="color:#999999;padding:10px;font-size:12px;font-family:\'lucida grande\',tahoma,verdana,arial,sans-serif"><a href="https://www.facebook.com/groups/tuhoccodeigniter" target="_blank">https://www.facebook.com/groups/tuhoccodeigniter</a></td></tr></tbody></table></td></tr></tbody></table></div>';
	}
}

if(!function_exists('xml2array')){
	function xml2array($xml) {
		$arr = array();
		foreach ($xml as $element){
			$tag = $element->getName();
			$e = get_object_vars($element);
			if(!empty($e)){
				$arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
			}
			else{
				$arr[$tag] = trim($element);
			}
		}
		return $arr;
	}
}
function time_elapsed_B($secs){
    $bit = array(
        ' năm'        => $secs / 31556926 % 12,
        ' tuần'        => $secs / 604800 % 52,
        ' ngày'        => $secs / 86400 % 7,
        ' giờ'        => $secs / 3600 % 24,
        ' phút'    => $secs / 60 % 60,
        ' giây'    => $secs % 60
        );
        
    foreach($bit as $k => $v){
        if($v > 1)$ret[] = $v . $k . '';
        if($v == 1)$ret[] = $v . $k;
        }
    array_splice($ret, count($ret)-1, 0, '');
    $ret[] = 'trước.';
    if($bit[' tuần']>1) return NULL;
    return join(' ', $ret);
 }
