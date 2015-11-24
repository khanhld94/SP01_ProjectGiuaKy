<section class="itq-tabs">
	<h1>Danh sách vị trí</h1>
	<ul>
		<li class="active"><a href="<?php echo site_url('backend_system/position/index');?>">Danh sách</a></li>
		<li><a href="<?php echo site_url('backend_system/position/add');?>">Thêm mới</a></li>
	</ul>
</section>
<section class="itq-view">
	<section class="advanced">
		<section class="search">
			<form method="get" action="<?php echo site_url('backend_system/position/index');?>">
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
	<section class="notification notification-error">Lưu ý: Đây là phần cấu hình ảnh hưởng đến cấu trúc hệ thống website. Bạn hãy thật chắc chắn khi sửa đổi hoặc xóa bỏ</section>
	<?php $message_flashdata = $this->session->flashdata('message_flashdata'); if(isset($message_flashdata) && count($message_flashdata)){ if($message_flashdata['type'] == 'successful'){ ?>
		<section class="notification notification-success"><?php echo $message_flashdata['message'];?></section>
	<?php } else if($message_flashdata['type'] == 'error'){ ?>
		<section class="notification notification-error"><?php echo $message_flashdata['message'];?></section>
	<?php } } ?>
	<section class="table">
		<form method="post" action="<?php echo site_url('backend_system/position/index');?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<table cellpadding="0" cellspacing="0" class="main">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo sort_general(array('field' => 'title', 'title' => 'Tên vị trí'), $config, $sort)?></th>
					<th><?php echo sort_general(array('field' => 'keyword', 'title' => 'Từ khóa'), $config, $sort)?></th>
					<th><?php echo sort_general(array('field' => 'count_config', 'title' => 'Config'), $config, $sort)?></th>
					<th><?php echo sort_general(array('field' => 'order', 'title' => 'Vị trí'), $config, $sort)?></th>
					<th><?php echo sort_general(array('field' => 'created', 'title' => 'Ngày tạo'), $config, $sort)?></th>
					<th><?php echo sort_general(array('field' => 'email_created', 'title' => 'Người tạo'), $config, $sort)?></th>
					<th><?php echo sort_general(array('field' => 'content', 'title' => 'JSON'), $config, $sort)?></th>
					<?php if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){ foreach($this->setconfig as $key => $val){ ?>
					<th><?php echo sort_general(array('field' => $key, 'title' => $val), $config, $sort)?></th>
					<?php } } ?>
					<th>Thao tác</th>
					<th class="last"><?php echo sort_general(array('field' => 'id', 'title' => 'Mã'), $config, $sort)?></th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($list_position) && count($list_position)){
				foreach($list_position as $key => $val) { 
				?>
				<tr>
					<td><?php echo (isset($config)?(($config['cur_page'] - 1)*$config['per_page']):0)+($key + 1); ?></td>
					<td class="left"><?php echo $val['title']; ?></td>
					<td class="left"><?php echo $val['keyword']; ?></td>
					<td><a href="<?php echo site_url('backend_system/config/index?positionid='.$val['id']);?>"><?php echo $val['count_config']; ?></a></td>
					<td><input type="input" name="order[<?php echo $val['id'];?>]" value="<?php echo $val['order'];?>" class="order" /></td>
					<td><?php echo show_time($val['created']); ?></td>
					<td><?php echo $val['email_created']; ?></td>
					<td><a href="<?php echo site_url('backend_system/position/json/'.$val['id']).'?redirect='.fullurl(TRUE);?>"><img src="template/backend/default/images/<?php echo !empty($val['content'])?'check':'uncheck';?>.png" /></a></td>
					<?php if(isset($this->setconfig) && is_array($this->setconfig) && count($this->setconfig)){ foreach($this->setconfig as $keyConfig => $valConfig){ ?>		
					<td><a href="<?php echo site_url('backend_system/position/set/'.$keyConfig.'/'.$val['id']).'?redirect='.fullurl(TRUE);?>" title="Trạng thái"><img src="template/backend/default/images/<?php echo ($val[$keyConfig] == 1)?'check':'uncheck';?>.png" title="<?php echo htmlspecialchars($valConfig);?>" /></a></td>
					<?php } } ?>
					<td><a href="<?php echo site_url('backend_system/position/delete/'.$val['id']).'?redirect='.fullurl(TRUE);?>"><img src="template/backend/default/images/delete.png" /></a><a href="<?php echo site_url('backend_system/position/updated/'.$val['id']).'?redirect='.fullurl(TRUE);?>"><img src="template/backend/default/images/edit.png" /></a></td>
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