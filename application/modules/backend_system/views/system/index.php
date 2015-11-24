<section class="itq-tabs">
	<h1>Cấu hình hệ thống</h1>
	<?php
	if(isset($list_position) && is_array($list_position) && count($list_position)){
		echo '<ul>';
		foreach($list_position as $key => $val){
			$active = '';
			if(empty($type) && $key == 0){
				$active = ' class="active"';
			}
			else if(!empty($type) && $type == $val['keyword']){
				$active = ' class="active"';
			}
			echo '<li'.$active.'><a href="'.site_url('backend_system/system/index/'.$val['keyword']).'">'.$val['title'].'</a></li>';
		}
		echo '</ul>';
	}
	?>
</section>
<section class="itq-form">
	<form method="post" action="">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<section class="main-panel main-panel-single">
		<header>Thông tin chung</header>
		<?php $message_flashdata = $this->session->flashdata('message_flashdata'); if(isset($message_flashdata) && count($message_flashdata)){ if($message_flashdata['type'] == 'successful'){ ?>
			<section class="notification notification-success"><?php echo $message_flashdata['message'];?></section>
		<?php } else if($message_flashdata['type'] == 'error'){ ?>
			<section class="notification notification-error"><?php echo $message_flashdata['message'];?></section>
		<?php } } ?>
		<?php $error = validation_errors(); echo (isset($error) && !empty($error))?'<ul class="error">'.$error.'</ul>':''; ?>
		<section class="block">
			<?php
			if(isset($list_config) && is_array($list_config) && count($list_config)){
				foreach($list_config as $key => $val){
					if($val['type'] == 'text'){
					?>
					<label class="item">
						<p class="label"><?php echo $val['title'];?>:</p>
						<input type="text" name="config[<?php echo $val['keyword'];?>]" value="<?php echo set_value($val['keyword'], $val['content']);?>" class="txtText"/>
					</label>
					<?php
					}
					else if($val['type'] == 'textarea'){
					?>
					<label class="item">
						<p class="label"><?php echo $val['title'];?>:</p>
						<textarea name="config[<?php echo $val['keyword'];?>]" class="txtTextarea"><?php echo set_value($val['keyword'], $val['content']);?></textarea>
					</label>
					<?php
					}
					else if($val['type'] == 'editor'){
					?>
					<label class="item">
						<p class="label"><?php echo $val['title'];?>:</p>
						<textarea name="config[<?php echo $val['keyword'];?>]" class="txtTextarea wysiwygEditor"><?php echo set_value($val['keyword'], $val['content']);?></textarea>
					</label>
					<?php
					}
					else if($val['type'] == 'checkbox'){
					?>
					<label class="item">
						<p class="label"><?php echo $val['title'];?>:</p>
						<section class="group">
							<label><input type="radio" name="config[<?php echo $val['keyword'];?>]" value="0" class="" <?php echo set_radio($val['keyword'], 0, ($val['content'] == 0)?TRUE:FALSE);?>/><span>Không</span></label>
							<label><input type="radio" name="config[<?php echo $val['keyword'];?>]" value="1" class="" <?php echo set_radio($val['keyword'], 1, ($val['content'] == 1)?TRUE:FALSE);?>/><span>Có</span></label>
						</section>
					</label>
					<?php
					}
					else if($val['type'] == 'file'){
					?>
					<label class="item">
						<p class="label"><?php echo $val['title'];?>:</p>
						<input type="text" name="config[<?php echo $val['keyword'];?>]" value="<?php echo set_value($val['keyword'], $val['content']);?>" class="txtText" id="txt<?php echo $val['keyword'];?>"/>
						<input type="button" value="Chọn" class="btnButton" onclick="browseKCFinder('txt<?php echo $val['keyword'];?>', 'file');return false;" />
					</label>
					<?php
					}
					else if($val['type'] == 'image'){
					?>
					<label class="item">
						<p class="label"><?php echo $val['title'];?>:</p>
						<input type="text" name="config[<?php echo $val['keyword'];?>]" value="<?php echo set_value($val['keyword'], $val['content']);?>" class="txtText" id="txt<?php echo $val['keyword'];?>"/>
						<input type="button" value="Chọn" class="btnButton" onclick="browseKCFinder('txt<?php echo $val['keyword'];?>', 'image');return false;" />
					</label>
					<?php
					}
				}
			}
			?>
			<section class="action">
				<p class="label">Thao tác:</p>
				<section class="group">
					<input type="submit" name="submit" value="Thay đổi"/>
					<input type="reset" value="Làm lại"/>
				</section>
			</section>
		</section><!-- .block -->
	</section><!-- .main-panel -->
	</form>
</section><!-- .itq-form -->