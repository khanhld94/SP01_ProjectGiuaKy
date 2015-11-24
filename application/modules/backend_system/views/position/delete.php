<section class="itq-tabs">
	<h1>Xóa vị trí</h1>
	<ul>
		<li><a href="<?php echo site_url('backend_system/position/index');?>">Danh sách</a></li>
		<li><a href="<?php echo site_url('backend_system/position/add');?>">Thêm mới</a></li>
	</ul>
</section><!-- .itq-tabs -->
<section class="itq-form">
	<form method="post" action="">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<input type="hidden" name="id" value="<?php echo set_value('id', $position['id'],'');?>">
	<section class="main-panel main-panel-single">
		<header>Thông tin chung</header>
		<section class="notification notification-error">Lưu ý: Đây là phần cấu hình ảnh hưởng đến cấu trúc hệ thống website. Bạn hãy thật chắc chắn khi sửa đổi hoặc xóa bỏ</section>
		<?php $error = validation_errors(); echo (isset($error) && !empty($error))?'<ul class="error">'.$error.'</ul>':''; ?>
		<section class="block">
			<label class="item">
				<p class="label">Tên vị trí:</p>
				<input type="text" name="title" value="<?php echo htmlspecialchars($position['title']);?>" class="txtText" disabled="disabled" />
			</label>
			<section class="action">
				<p class="label">Thao tác:</p>
				<section class="group">
					<input type="submit" name="submit" value="Xóa bỏ"/>
				</section>
			</section>
		</section><!-- .block -->
	</section><!-- .main-panel -->
	</form>
</section><!-- .itq-form -->