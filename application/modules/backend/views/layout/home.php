<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?></title>
<base href="<?php echo base_url();?>" />
<meta name="keywords" content="<?php echo isset($meta_keywords)?htmlspecialchars($meta_keywords):'';?>" />	
<meta name="description" content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />
<link href="<?php echo base_url('template/backend/default/css/normalize.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('template/backend/default/css/style.css')?>" rel="stylesheet" type="text/css" />
<!--[if IE]><script src="<?php echo base_url('template/backend/default/js/html5.js')?>"></script><![endif]-->
</head>
<body>
<header class="itq-header">
	<p class="main-title">Hệ thống quản trị website</p>
</header>
<nav class="navigation">
	<?php $this->load->view('backend/layout/navigation');?>
	<ul class="user-account">
		<li>Chào <strong><?php echo isset($this->user['fullname'])?$this->user['fullname']:$this->user['email'];?></strong></li>
		<li><a target="blank" href="<?php echo site_url('');?>" title="Thông tin">Trang chủ</a></li>
		<li><a href="<?php echo site_url('frontend_user/user/logout');?>" title="Đăng xuất" onclick="return confirm('Are you sure?');">Đăng xuất</a></li>
	</ul>
</nav>
<?php $this->load->view(isset($template)?$template:NULL);?>
<footer><p>Copyright &copy; 2015 - Powered by <a href="http://thietkewebpmax.com/" title="Thiết kế Website Pmax">thietkewebpmax.com</a></p></footer>
<script src="<?php echo base_url('template/backend/default/js/1.7.2.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('template/backend/default/plugins/jquery.number.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('template/backend/default/js/function.js')?>" type="text/javascript"></script>
<?php
$this->load->view('common/tinymce_3511');
(DEBUG == TRUE)?$this->output->enable_profiler(TRUE):'';
?>
</body>
</html>