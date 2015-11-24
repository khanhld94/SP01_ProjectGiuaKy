
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="<?php echo $post['image'];?>" alt="" />
								<h3>ZOOM</h3>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item active">
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar1.jpg" alt=""></a>
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar2.jpg" alt=""></a>
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar3.jpg" alt=""></a>
										</div>
										<div class="item">
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar1.jpg" alt=""></a>
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar2.jpg" alt=""></a>
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar3.jpg" alt=""></a>
										</div>
										<div class="item">
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar1.jpg" alt=""></a>
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar2.jpg" alt=""></a>
										  <a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/similar3.jpg" alt=""></a>
										</div>
										
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/new.jpg" class="newarrival" alt="" />
								<h2><?php echo $post['title'];?></h2>
								<p>Người đăng : <?php echo $user['fullname'];?></p>
								<p>Mô tả ngắn : <?php echo $post['description'];?></p>
								<img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/rating.png" alt="" />
								<span>
									<a class="btn btn-fefault cart" href="exchange">
										<i class="fa fa-exchange"></i>
										Trao đổi
									</a>
								</span>
			
								<a href=""><img src="<?php echo base_url('template/frontend/eshop');?>/images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
				</div>
					