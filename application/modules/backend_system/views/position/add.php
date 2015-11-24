<section class="itq-tabs">
	<h1>Thêm vị trí</h1>
	<ul>
		<li><a href="<?php echo site_url('backend_system/position/index');?>">Danh sách</a></li>
		<li class="active"><a href="<?php echo site_url('backend_system/position/add');?>">Thêm mới</a></li>
	</ul>
</section><!-- .itq-tabs -->
<section class="itq-form">
	<form method="post" action="">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<section class="main-panel">
		<header>Thông tin chung</header>
		<?php $error = validation_errors(); echo (isset($error) && !empty($error))?'<ul class="error">'.$error.'</ul>':''; ?>
		<section class="block">
			<label class="item">
				<p class="label">Tên vị trí:</p>
				<input type="text" name="title" value="<?php echo set_value('title', '');?>" class="txtText"/>
			</label>
			<label class="item">
				<p class="label">Từ khóa:</p>
				<input type="text" name="keyword" value="<?php echo set_value('keyword', '');?>" class="txtText"/>
			</label>
			<label class="item">
				<p class="label">Dữ liệu HTML:</p>
				<textarea name="content" class="txtTextarea" id="txtContent"><?php echo set_value('content', '');?></textarea>
			</label>
			<section class="action">
				<p class="label">Thao tác:</p>
				<section class="group">
					<input type="submit" name="submit" value="Thêm mới"/>
					<input type="reset" value="Làm lại"/>
				</section>
			</section>
		</section>
	</section><!-- .main-panel -->
	<aside class="side-panel">
		<?php if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){ ?>
		<section class="block">
			<header>Tùy chọn</header>
			<section class="container">
			<?php foreach($this->setconfig as $key => $val){ ?>
			<section class="checkbox-radio">
				<p class="label"><?php echo $val;?>:</p>
				<section class="group">
					<label><input type="radio" name="<?php echo $key;?>" value="0" class="" <?php echo set_radio($key, 0);?>/><span>Không</span></label>
					<label><input type="radio" name="<?php echo $key;?>" value="1" class="" <?php echo set_radio($key, 1, TRUE);?>/><span>Có</span></label>
				</section>
			</section>
			<?php } ?>
			</section><!-- .container -->
		</section><!-- .block -->
		<?php } ?>
	</aside><!-- .side-panel -->
	</form>
</section><!-- .itq-form -->