<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?></title>
<base href="<?php echo base_url();?>" />
<meta name="keywords" content="<?php echo isset($meta_keywords)?htmlspecialchars($meta_keywords):'';?>" />	
<meta name="description" content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />
<link href="<?php echo base_url('template/backend/default/css/normalize.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('template/backend/default/css/login.css')?>" rel="stylesheet" type="text/css" />
<!--[if IE]><script src="<?php echo base_url('template/backend/default/js/html5.js')?>"></script><![endif]-->
</head>
<body>
<header></header>
<section class="itq-wrapper">
	<?php $this->load->view(isset($template)?$template:NULL);?>
</section><!-- .itq-wrapper -->
<footer><p>Copyright &copy; 2015 - Powered by <a href="http://thietkewebpmax.com/" title="Thiết kế Website Pmax">thietkewebpmax.com</a></p></footer>
<?php
$this->load->view('common/tinymce_3511');
(DEBUG == TRUE)?$this->output->enable_profiler(TRUE):'';
?>
</body>
</html>