				
				<div class="col-sm-9 padding-right">
					<div class="category-tab"><!--category-tab-->
						<ul class="nav nav-tabs">
							<li class="active"><a href="<?php echo site_url('frontend/home');?>">Sản phẩm</a></li>
							<?php if(isset($this->user) && is_array($this->user) && count($this->user)){
										//print_r($this->authentication);
									?>
							<li><a href="<?php echo site_url('frontend/manager');?>">Quản lý hộp đồ</a></li>
							<li><a href="<?php echo site_url('frontend/notification');?>"><?php echo 'Có '.count($notifi);?> thông báo</a></li>
							<?php }?>
						</ul>
					</div>
					<?php if(isset($list_post)&&is_array($list_post)&&count($list_post)){?>
					<div class="col-sm-12">
						<div class="tab-content">
							<div class="tab-pane fade active in" id="article">								
								<?php foreach ($list_post as $key => $value) { 
									$title = htmlspecialchars($value['title']);
									$image = $value['image']; 
									$time =	 strtotime($value['created']);
									$time = time_elapsed_B(time()-$time) ? time_elapsed_B(time()-$time):show_time($value['created']);
									$href = rewrite_url(array('module' => 'article', 'canonical' => $value['canonical'], 'slug' => $value['slug'], 'id' => $value['id']));
								?>
								<!-- SHOW -->
								<div class="col-sm-12 product">
									<div class="product-image-wrapper col-sm-4">
										<img style="" src="<?php echo $image;?>" alt="" />
									</div>
									<div class="productinfo text-left col-sm-4">
										<h2><?php echo $title;?></h2>
										<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-comments-o"></i>Đánh giá</a>
										<a href="<?php echo $href;?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>
									</div>
									<div class="time-info text-right col-sm-4">
										<p>Đăng bởi <?php echo $value['email_created'];?></p>
										<p>Thời gian :<?php echo $time;?></p>
									</div>
<!-- -->
								</div><?php } ?>
								<?php if(isset($list_pagination)) echo $list_pagination;?>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
		<!--/category-tab-->