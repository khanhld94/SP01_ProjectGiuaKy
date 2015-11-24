<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo base_url('template/frontend/eshop');?>/css/animate.css" rel="stylesheet">
	<link href="<?php echo base_url('template/frontend/eshop');?>/css/main.css" rel="stylesheet">
	<link href="<?php echo base_url('template/frontend/eshop');?>/css/responsive.css" rel="stylesheet">
</head><!--/head-->

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
					<div class="col-sm-8">
						<div class="col-sm-6">
							<section class="itq-view" style="padding-top: 10px;">
								<?php $message_flashdata = $this->session->flashdata('message_flashdata'); if(isset($message_flashdata) && count($message_flashdata)){ if($message_flashdata['type'] == 'successful'){ ?>
									<section class="notification notification-success"><?php echo $message_flashdata['message'];?></section>
								<?php } else if($message_flashdata['type'] == 'error'){ ?>
									<section class="notification notification-error"><?php echo $message_flashdata['message'];?></section>
								<?php } } ?>
							</section><!-- .itq-view -->
						</div>
						<div class="col-sm-6">
							<div class="shop-menu pull-right">
								<ul class="nav navbar-nav">
									<?php if(isset($this->user) && is_array($this->user) && count($this->user)){
										//print_r($this->authentication);
									?>

									<li><a><img width="50" height="50" src="<?php echo $this->user['avatar'] ;?>"/></a></li>
									<li><a href=""><i class="fa fa-user"></i>Xin chào <?php echo $this->user['fullname'];?></a></li>
									<li><a href="<?php echo site_url('frontend_user/authentication/logout');?>">Đăng xuất</a></li>
									<li><a target="blank" href="<?php echo site_url('backend_article/post');?>">Quản lý sản phẩm</a></li>
									
									<?php }else{?>

									<li><a href="<?php echo site_url('frontend_user/authentication/register');?>" class="active"><i class="fa fa-lock"></i>Đăng Ký</a></li>
									<li><a href="<?php echo site_url('frontend_user/authentication/login');?>" class="active"><i class="fa fa-lock"></i>Đăng Nhập</a></li>
									
									<?php }?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							<div class="item active">
								<img src="<?php echo base_url('template/frontend/eshop');?>/images/banner.jpg">
							</div>
							<div class="item">
								<img src="<?php echo base_url('template/frontend/eshop');?>/images/banner.jpg">
							</div>
							<div class="item">
								<img src="<?php echo base_url('template/frontend/eshop');?>/images/banner.jpg">
							</div>
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	<section class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php $this->load->view('common/aside');?>
					<?php if(isset($template))$this->load->view($template);?>
				</div>
			</div>
	</section>
	<?php $this->load->view('common/footer');?>
	
    <script src="<?php echo base_url('template/frontend/eshop');?>/js/jquery.js"></script>
	<script src="<?php echo base_url('template/frontend/eshop');?>/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('template/frontend/eshop');?>/js/jquery.scrollUp.min.js"></script>
    <script src="<?php echo base_url('template/frontend/eshop');?>/js/jquery.prettyPhoto.js"></script>
</body>
</html>