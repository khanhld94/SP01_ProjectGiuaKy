
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
				<?php $message_flashdata = $this->session->flashdata('message_flashdata'); if(isset($message_flashdata) && count($message_flashdata)){ if($message_flashdata['type'] == 'successful'){ ?>
				<section class="notification notification-success"><?php echo $message_flashdata['message'];?></section>
				<?php } else if($message_flashdata['type'] == 'error'){ ?>
				<section class="notification notification-error"><?php echo $message_flashdata['message'];?></section>
				<?php } } ?>
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<?php $error = validation_errors(); echo (isset($error) && !empty($error))?'<ul class="error">'.$error.'</ul>':''; ?>
						<form method="post" action="">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
							<input type="email" placeholder="email" name="email" />
							<input type="password" placeholder="password" name="password" />
							<label><a href="<?php echo site_url('frontend_user/authentication/register');?>">Đăng ký</a></label>
							<button type="submit" name="submit" value="Đăng nhập" class="btn btn-default">Đăng Nhập</button>
							</div>
						</form>
					</div><!--/login form-->
				</div>
			</div>
		</div>
	</section><!--/form-->