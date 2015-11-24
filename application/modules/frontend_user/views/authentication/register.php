
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<section id="form"><!--form-->
					<header><h2 class="title">Tạo tài khoản</h2></header>
					<?php $message_flashdata = $this->session->flashdata('message_flashdata'); if(isset($message_flashdata) && count($message_flashdata)){ if($message_flashdata['type'] == 'successful'){ ?>
					<section class="notification notification-success"><?php echo $message_flashdata['message'];?></section>
					<?php } else if($message_flashdata['type'] == 'error'){ ?>
					<section class="notification notification-error"><?php echo $message_flashdata['message'];?></section>
					<?php } } ?>
					<div class="form col-sm-6"><!--login form-->
						<form class="form-horizontal" method="post" action="">
							<div class="error"><?php $error = validation_errors(); echo (isset($error) && !empty($error))?'<ul class="error">'.$error.'</ul>':''; ?></div>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Tên:</label>
								<div class="col-sm-8">
									<input class="form-control" type="text" placeholder="Tên" name="fullname"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Email:</label>
								<div class="col-sm-8">
									<input class="form-control" type="email" placeholder="Email" name="email" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Mật khẩu:</label>
								<div class="col-sm-8">
									<input class="form-control"  accept=" " type="password" placeholder="Mật khẩu" name="password" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Nhập lại mật khẩu:</label>
								<div class="col-sm-8">
									<input class="form-control"  type="password" placeholder="Nhập Lại mật khẩu" name="repassword" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Số điện thoại:</label>
								<div class="col-sm-8">
									<input class="form-control"  type="text" placeholder="Phone" name="mobile" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Ảnh đại diện:</label>
								<div class="col-sm-6">
									<input type="text" name="avatar" value="" placeholder="Ảnh đại diện" class="form-control" id="txtImage"/>
								</div>
								<button type="button" value="Chọn" class="btnButton btn btn-default" onclick="browseKCFinder('txtImage', 'image');return false;">Tải ảnh</button>
							</div>
							<div class="form-group"> 
								<label class="control-label col-sm-4" for="email">Thao tác:</label>
    							<div class="col-sm-8">
      								<button name="submit" type="submit" class="btn btn-default" value="Đăng ký">Đăng ký</button>
    							</div>
 							</div>
						</form>
					</div><!--/login form-->
				</section><!--/form-->
			</div>
		</div>
	</div>