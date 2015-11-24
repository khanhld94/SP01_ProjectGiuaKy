<section class="itq-tabs">
	<h1>Cập nhật bài viết</h1>
	<ul>
		<li><a href="<?php echo site_url('backend_article/post/index');?>">Danh sách</a></li>
		<li><a href="<?php echo site_url('backend_article/post/add');?>">Thêm mới</a></li>
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
				<p class="label">Tiêu đề:</p>
				<input type="text" name="title" value="<?php echo set_value('title', $post['title']);?>" class="txtText"/>
			</label>
			<label class="item">
				<p class="label">Danh mục:</p>
				<?php echo form_dropdown('catalogueid', $dropdown_catalogueid, set_value('catalogueid', $post['catalogueid']), ' class="cbSelect"');?>
			</label>
			<label class="item">
				<p class="label">Ảnh đại diện:</p>
				<input type="text" name="image" value="<?php echo set_value('image', $post['image']);?>" class="txtText" id="txtImage"/>
				<input type="button" value="Chọn" class="btnButton" onclick="browseKCFinder('txtImage', 'image');return false;" />
			</label>
			<label class="item">
				<p class="label">Mô tả ngắn:</p>
				<textarea name="description" class="txtTextarea wysiwygEditor" id="txtDescription"><?php echo set_value('description', $post['description']);?></textarea>
			</label>
			<label class="item">
				<p class="label">Nội dung:</p>
				<textarea name="content" class="txtTextarea wysiwygEditorContent" id="txtContent"><?php echo set_value('content', $post['content']);?></textarea>
			</label>
			<section class="action">
				<p class="label">Thao tác:</p>
				<section class="group">
					<input type="submit" name="submit" value="Thay đổi"/>
					<input type="reset" value="Làm lại"/>
				</section>
			</section>
		</section>
	</section><!-- .main-panel -->
	</form>
</section><!-- .itq-form -->