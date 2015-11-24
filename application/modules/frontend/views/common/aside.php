				<div class="col-sm-3">
					<div class="left-sidebar">
					<!--Tìm Kiếm -->
						<h2>Tìm kiếm</h2>
						<div class="panel-group category-products clearfix" id="accordian"><!--category-productsr-->
							<div class="col-sm-12">
								<div class="tab-content">
									<div class="tab-pane fade active in" id="article">
										<form class="Search clearfix" method="get" action="">
											<input  type="text" class="form-control" name="keyword" placeholder="Tìm kiếm" value="<?php echo (isset($keyword) && !empty($keyword))?htmlspecialchars($keyword):'';?>"/>
											<?php echo form_dropdown('catalogueid', $dropdown_catalogueid, set_value('catalogueid', $catalogueid), ' class="form-control"');?>
											<button type="submit" class="btn btn-default">Tìm</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>