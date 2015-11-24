<section class="itq-tabs">
	<h1>Thêm danh mục</h1>
	<ul>
		<li><a href="<?php echo site_url('backend_article/catalogue/index');?>">Danh sách</a></li>
		<li class="active"><a href="<?php echo site_url('backend_article/catalogue/add');?>">Thêm mới</a></li>
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
				<p class="label">Tên danh mục:</p>
				<input type="text" name="title" value="<?php echo set_value('title', '');?>" class="txtText"/>
			</label>
			<label class="item">
				<p class="label">Danh mục cha:</p>
				<?php echo form_dropdown('parentid', $dropdown_parentid, set_value('parentid', 0), ' class="cbSelect"');?>
			</label>
			<label class="item">
				<p class="label">Ảnh đại diện:</p>
				<input type="text" name="image" value="<?php echo set_value('image', '');?>" class="txtText" id="txtImage"/>
				<input type="button" value="Chọn" class="btnButton" onclick="browseKCFinder('txtImage', 'image');return false;" />
			</label>
			<label class="item">
				<p class="label">Mô tả ngắn:</p>
				<textarea name="description" class="txtTextarea wysiwygEditor" id="txtDescription"><?php echo set_value('description', '');?></textarea>
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
		<section class="block">
			<header>Cấu hình</header>
			<section class="container">
				<label class="item">
					<p class="label">Canonical:</p>
					<input type="text" name="canonical" value="<?php echo set_value('canonical', '');?>" class="txtText"/>
				</label>
			</section><!-- .container -->
		</section><!-- .block -->
		<section class="block">
			<header>Meta</header>
			<section class="container">
				<label class="item">
					<p class="label">Title:</p>
					<input type="text" name="meta_title" value="<?php echo set_value('meta_title', '');?>" class="txtText"/>
				</label>
				<label class="item">
					<p class="label">Keywords:</p>
					<input type="text" name="meta_keywords" value="<?php echo set_value('meta_keywords', '');?>" class="txtText"/>
				</label>
				<label class="item">
					<p class="label">Description:</p>
					<textarea name="meta_description" class="txtTextarea"><?php echo set_value('meta_description', '');?></textarea>
				</label>
			</section><!-- .container -->
		</section><!-- .block -->
	</aside><!-- .side-panel -->
	</form>
</section><!-- .itq-form -->