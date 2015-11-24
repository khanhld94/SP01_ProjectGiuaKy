				<div class="col-sm-9 padding-right">
					<div class="category-tab"><!--category-tab-->
						<ul class="nav nav-tabs">
							<li><a href="<?php echo site_url('frontend/home');?>" >Đồ Vật</a></li>
							<?php if(isset($this->user) && is_array($this->user) && count($this->user)){
										//print_r($this->authentication);
									?>
							<li><a href="<?php echo site_url('frontend/manager');?>">Quản lý hộp đồ</a></li>
							<li><a href="<?php echo site_url('frontend/notification');?>"><?php echo 'Có '.count($notifi);?> thông báo</a></li>
							<?php }?>
						</ul>
					</div>
					<?php if (isset($UserSend)&&is_array($UserSend)&&count($UserSend)){ ?>
					<div class="col-sm-12 product">
						<div class="tab-content col-sm-8">
							<ul>
								<?php foreach ($UserSend as $key => $value) {
								?>
								<li>
									<div class="alert alert-info">
  										<strong>Yêu cầu trao đổi !</strong> từ <?php echo $value['fullname'];?>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<?php }else{?>
					<p>Không có thông báo nào </p>
					<?php } ?>
				</div>