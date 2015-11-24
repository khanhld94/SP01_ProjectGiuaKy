<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <base href="<?php echo base_url();?>" />
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/animate.css" rel="stylesheet">
	<link href="<?php echo base_url('template/frontend/eshop');?>/css/main.css" rel="stylesheet">
	<link href="<?php echo base_url('template/frontend/eshop');?>/css/responsive.css" rel="stylesheet">
</head>
<body>
<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="<?php echo site_url();?>"><img src="<?php echo base_url('template/frontend/eshop');?>/images/home/logo.png" alt="" /></a>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	</header><!--/header-->
	<?php $this->load->view(isset($template)?$template:null);?>
	<?php $this->load->view('frontend/common/footer');?>
	
    <script src="<?php echo base_url('template/frontend/eshop');?>/js/jquery.js"></script>
	<script src="<?php echo base_url('template/frontend/eshop');?>/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('template/frontend/eshop');?>/js/jquery.scrollUp.min.js"></script>
    <script src="<?php echo base_url('template/frontend/eshop');?>/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo base_url('template/frontend/eshop');?>/js/main.js"></script>
	<script src="<?php echo base_url('template/backend/default/js/function.js')?>" type="text/javascript"></script>
	<?php
	$this->load->view('common/tinymce_3511');
	(DEBUG == TRUE)?$this->output->enable_profiler(TRUE):'';
	?>
</body>
</html>