				<div class="col-sm-9 padding-right">
					<div class="category-tab"><!--category-tab-->
						<ul class="nav nav-tabs">
							<li><a>Xác nhận trao đổi</a></li>
						</ul>
					</div>
					<div class="col-sm-12">
						<div class="tab-content">
							<div class="product col-sm-5">
								<section class="image">
									<img src="<?php echo $product1['image'];?>"/>
								</section>
								<div class="info">
									<h3><?php echo $product1['title'];?></h3>
									<h3>mail : <?php echo $userid1['email'];?></h3>
								</div>
							</div>
							<div class="col-sm-2">
								<form method="post" action="">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
									<button name="submit" type="submit" class="btn btn-success" value="Trao đổi">Trao đổi</button>
								</form>
							</div>
							<div class="product col-sm-5">
								<section class="image">
									<img src="<?php echo $product2['image'];?>"/>
								</section>
								<div class="info">
									<h3><?php echo $product2['title'];?></h3>
									<h3>mail : <?php echo $userid2['email'];?></h3>
								</div>
							</div>
						</div>	
					</div>
				</div>