<section class="itq-tabs">
	<h1>Danh sách danh mục</h1>
	<ul>
		<li class="active"><a href="<?php echo site_url('backend_article/catalogue/index');?>">Danh sách</a></li>
		<li><a href="<?php echo site_url('backend_article/catalogue/add');?>">Thêm mới</a></li>
	</ul>
</section>
<section class="itq-view">
	<section class="advanced">
		<section class="search">
			<form method="get" action="<?php echo site_url('backend_article/catalogue/index');?>">
				<input type="text" name="keyword" class="text" value="<?php echo (isset($keyword) && !empty($keyword))?htmlspecialchars($keyword):'';?>"/>
				<input type="submit" class="submit" value="Tìm kiếm" />
			</form>
		</section><!-- .search -->
		<section class="tool">
			<form method="post" action="">
				<input type="button" value="Sắp xếp" onclick="document.getElementById('btnSort').click(); return false;" />
			</form>
		</section><!-- .tool -->
	</section><!-- .advanced -->
	<?php $message_flashdata = $this->session->flashdata('message_flashdata'); if(isset($message_flashdata) && count($message_flashdata)){ if($message_flashdata['type'] == 'successful'){ ?>
		<section class="notification notification-success"><?php echo $message_flashdata['message'];?></section>
	<?php } else if($message_flashdata['type'] == 'error'){ ?>
		<section class="notification notification-error"><?php echo $message_flashdata['message'];?></section>
	<?php } } ?>
	<section class="table">
		<form method="post" action="<?php echo site_url('backend_article/catalogue/index');?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<table cellpadding="0" cellspacing="0" class="main">
			<thead>
				<tr>
					<th>#</th>
					<th class="main">Tên danh mục</th>
					<th>Bài viết</th>
					<th>Lft</th>
					<th>Rgt</th>
					<th>Vị trí</th>	
					<th>Ngày tạo</th>
					<th>Người tạo</th>
					<?php if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){ foreach($this->setconfig as $key => $val){ ?>
					<th><?php echo $val;?></th>
					<?php } } ?>
					<th>Thao tác</th>
					<th class="last">Mã</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($list_catalogue) && count($list_catalogue)){
				foreach($list_catalogue as $key => $val) { 
				$href = rewrite_url(array('module' => 'article_catalogue', 'canonical' => $val['canonical'], 'slug' => $val['slug'], 'id' => $val['id']));
				?>
				<tr>
					<td><?php echo (isset($config)?(($config['cur_page'] - 1)*$config['per_page']):0)+($key + 1); ?></td>
					<td class="left">
						<a href="<?php echo $href;?>" target="_blank"><?php echo str_repeat('|-----', (($val['level'] > 0)?($val['level'] - 1):0)).$val['title']; ?></a>
					</td>
					<td><a href="<?php echo site_url('backend_article/post/index').'?catalogueid='.$val['id'];?>"><?php echo $val['count_article']; ?></a></td>
					<td><?php echo $val['lft']; ?></td>
					<td><?php echo $val['rgt']; ?></td>
					<td><input type="input" name="order[<?php echo $val['id'];?>]" value="<?php echo $val['order'];?>" class="order" /></td>
					<td><?php echo show_time($val['created']); ?></td>
					<td><?php echo $val['email_created']; ?></td>
					<?php if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){ foreach($this->setconfig as $keyConfig => $valConfig){ ?>		
					<td><a href="<?php echo site_url('backend_article/catalogue/set/'.$keyConfig.'/'.$val['id']).'?redirect='.fullurl(TRUE);?>" title="Trạng thái"><img src="template/backend/default/images/<?php echo ($val[$keyConfig] == 1)?'check':'uncheck';?>.png" title="<?php echo htmlspecialchars($valConfig);?>" /></a></td>
					<?php } } ?>
					<td><a href="<?php echo site_url('backend_article/catalogue/delete/'.$val['id']).'?redirect='.fullurl(TRUE);?>"><img src="template/backend/default/images/delete.png" /></a><a href="<?php echo site_url('backend_article/catalogue/updated/'.$val['id']).'?redirect='.fullurl(TRUE);?>"><img src="template/backend/default/images/edit.png" /></a></td>
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
		</section><!-- .table -->
		</form>
	</section><!-- .table -->
	<?php echo isset($list_pagination)?$list_pagination:'';?>
</section><!-- .itq-view -->