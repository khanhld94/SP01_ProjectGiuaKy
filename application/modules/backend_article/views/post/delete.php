<section class="itq-tabs">
	<h1>Xóa bài viết</h1>
	<ul>
		<li><a href="<?php echo site_url('backend_article/post/index');?>">Danh sách</a></li>
		<li><a href="<?php echo site_url('backend_article/post/add');?>">Thêm mới</a></li>
	</ul>
</section><!-- .itq-tabs -->
<section class="itq-form">
	<form method="post" action="">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<input type="hidden" name="id" value="<?php echo set_value('id', $post['id'],'');?>">
	<section class="main-panel main-panel-single">
		<header>Thông tin chung</header>
		<?php $error = validation_errors(); echo (isset($error) && !empty($error))?'<ul class="error">'.$error.'</ul>':''; ?>
		<section class="block">
			<label class="item">
				<p class="label">Tiêu đề:</p>
				<input type="text" name="title" value="<?php echo htmlspecialchars($post['title']);?>" class="txtText" disabled="disabled" />
			</label>
			<label class="item">
				<p class="label">Mô tả ngắn:</p>
				<section style="display: inline-block;background: #EEE !important;background: #EEE !important;background: #FFFFFF;border: 1px solid #CCC;font-size: 11px;padding: 5px 5px;margin: 0px;color: #333;width: 500px;"><?php echo $post['description'];?></section>
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