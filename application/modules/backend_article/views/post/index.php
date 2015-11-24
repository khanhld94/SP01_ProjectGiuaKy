<section class="itq-tabs">
	<h1>Danh sách bài đăng</h1>
	<ul>
		<li class="active"><a href="<?php echo site_url('backend_article/post/index');?>">Danh sách</a></li>
		<li><a href="<?php echo site_url('backend_article/post/add');?>">Thêm mới</a></li>
	</ul>
</section>
<section class="itq-view">
	<section class="advanced">
		<section class="search">
			<form method="get" action="<?php echo site_url('backend_article/post/index');?>">
				<input type="text" name="keyword" class="text" value="<?php echo (isset($keyword) && !empty($keyword))?htmlspecialchars($keyword):'';?>"/>
				<?php echo form_dropdown('catalogueid', $dropdown_catalogueid, set_value('catalogueid', $catalogueid), ' class="cbSelect"');?>
				<input type="submit" class="submit" value="Tìm kiếm" />
			</form>
		</section><!-- .search -->
		<!-- <section class="tool">
			<form method="post" action="">
				<input type="button" value="Xóa nhiều" onclick="if(confirm('Are you sure?')){document.getElementById('btnDelete').click()}" />
				<input type="button" value="Sắp xếp" onclick="document.getElementById('btnSort').click(); return false;" />
			</form>
		</section> --><!-- .tool -->
	</section><!-- .advanced -->
	<?php $message_flashdata = $this->session->flashdata('message_flashdata'); if(isset($message_flashdata) && count($message_flashdata)){ if($message_flashdata['type'] == 'successful'){ ?>
		<section class="notification notification-success"><?php echo $message_flashdata['message'];?></section>
	<?php } else if($message_flashdata['type'] == 'error'){ ?>
		<section class="notification notification-error"><?php echo $message_flashdata['message'];?></section>
	<?php } } ?>
	<section class="table">
		<form method="post" action="<?php echo site_url('backend_article/post/index');?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<table cellpadding="0" cellspacing="0" class="main">
			<thead>
				<tr>
					<th>#</th>
					<th><input type="checkbox" id="check-all" /></th>
					<th class="main">Bài Đăng</th>
					<th>Danh mục</th>
					<th>Vị trí</th>
					<th>Ngày tạo</th>
					<th>Người tạo</th>
					<th>Thao tác</th>
					<th class="last">Mã</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($list_post) && count($list_post)){
				foreach($list_post as $key => $val){ 
				$href = rewrite_url(array('module' => 'article', 'canonical' => $val['canonical'], 'slug' => $val['slug'], 'id' => $val['id']));
				?>
				<tr>
					<td><?php echo (isset($config)?($config['cur_page']*$config['per_page']):0)+($key + 1); ?></td>
					<td><input type="checkbox" name="check[<?php echo $val['id'];?>]" value="1" class="check-all" /></td>
					<td class="left"><a href="<?php echo $href;?>" target="_blank"><?php echo $val['title']; ?></a></td>
					<td class="left"><a href="<?php echo site_url('backend_article/post/index').'?catalogueid='.$val['catalogueid'];?>"><?php echo $val['catalogue_title']; ?></a></td>
					<td><input type="input" name="order[<?php echo $val['id'];?>]" value="<?php echo $val['order'];?>" class="order" /></td>
					<td><?php echo show_time($val['created']); ?></td>
					<td><?php echo $val['email_created']; ?></td>
					<td><a href="<?php echo site_url('backend_article/post/delete/'.$val['id']).'?redirect='.fullurl(TRUE);?>"><img src="template/backend/default/images/delete.png" /></a><a href="<?php echo site_url('backend_article/post/update/'.$val['id']).'?redirect='.fullurl(TRUE);?>"><img src="template/backend/default/images/edit.png" /></a></td>
					<td class="last"><?php echo $val['id'];?></td>
				</tr>
			<?php }} else {?>
				<tr>
					<td colspan="69" class="last">Không có dữ liệu</td>
				</tr>
			<?php }?>	
			</tbody>
		</table>
		<section class="display-none">
			<input type="submit" name="sort" value="Sắp xếp" id="btnSort" />
			<input type="submit" name="delete" value="Xóa nhiều" id="btnDelete" />
		</section><!-- .table -->
		</form>
	</section><!-- .table -->
	<?php echo isset($list_pagination)?$list_pagination:'';?>
</section><!-- .itq-view -->