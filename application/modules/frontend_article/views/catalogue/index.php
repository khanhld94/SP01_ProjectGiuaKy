			<section class="panelMain">
				<header class="mainHeader">
					<section class="breadCrumd">
						<ul class="clearfix">
						<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
							<a rel="nofollow" href="<?php echo site_url();?>" title="<?php echo lang('Trang chủ');?>" itemprop="url">
								<span itemprop="title"><?php echo lang('Trang chủ');?></span>
							</a>
						</li>
						<?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){ ?>
						<?php $count = count($breadcrumb); ?>
						<?php foreach($breadcrumb as $key => $val){ ?>
							<?php
							$h = ($count - ($key - 1));
							$title = htmlspecialchars($val['title']);
							$href = rewrite_url(array('module' => 'article_catalogue', 'canonical' => $val['canonical'], 'slug' => $val['slug'], 'id' => $val['id']));
							?>
							<li><i class="fa fa-angle-right"></i></li>
							<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
								<?php echo ($h <= 6)?('<h'.$h.'>'):'';?>
								<a href="<?php echo $href;?>" title="<?php echo $title;?>" itemprop="url">
									<span itemprop="title"><?php echo $title;?></span>
								</a>
								<?php echo ($h <= 6)?('</h'.$h.'>'):'';?>
							</li>
						<?php } ?>
						<?php } ?>
							</ul>
					</section>
				</header>
				<section class="article-listview clearfix">
				<?php if(isset($list_post)&&is_array($list_post)&&count($list_post)){?>
				<?php	foreach ($list_post as $key => $value) {
					$href = rewrite_url(array('module' => 'article', 'canonical' => $value['canonical'], 'slug' => $value['slug'], 'id' => $value['id']));
					$title = htmlspecialchars($value['title']);
					$info = show_time($value['created']);
					$description = $value['description'];
					$image = $value['image'];
					?>
					 <article class="clearfix">
					 	<figure><a href="<?php echo $href;?>" title="<?php echo $title;?>"><img src="<?php echo $image;?>" title="<?php echo $title;?>"></a></figure>
					 	<h4 class="title"><a href="<?php echo $href;?>"><?php echo $title;?></a></h4>
					 	<section class="info"><?php echo $info;?></section>
					 	<section class="description"><?php echo $description;?></section>
					</article>
					<?php } ?>				
				<?php echo isset($list_pagination)?$list_pagination:'';?>
				<?php }else echo "<h3>Không có tin trong mục này</h3>";?></section>

			</section>