<?php $session = $this->session->userdata('user_session'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('manage') ,' ', $this->lang->line('supplier_prodcut'); ?></h1>
        </div>
    </div>
</div>

<?php if(count($products) > 0){ ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="tabbable tabs-left">
				<form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'supplier/product/' . $supplier_details->id; ?>">
					<div class="form-group">
		                <label class="col-lg-2 control-label">&nbsp;</label>
		                <div class="col-lg-9 text-right">
		                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
		                    <a href="<?php echo USER_URL . 'supplier' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
		                </div>
		            </div>

					<ul id="product_selection" class="nav nav-tabs tab-green">
						<?php $i = 0; ?>
						<?php foreach ($products as $product_category) { ?>
							<li class="<?php echo (++$i == 1) ? 'active' : ''; ?>">
								<a href="#panel_tab<?php echo $product_category['category_id']; ?>" data-toggle="tab">
									<i class="pink icon-cog"></i> <?php echo$product_category['category_name']; ?>
								</a>
							</li>
						<?php } ?>
					</ul>
					<div class="tab-content">
						<?php $i = 0; ?>
						<?php foreach ($products as $product_category) { ?>
							<div class="tab-pane <?php echo (++$i == 1) ? 'active' : ''; ?>" id="panel_tab<?php echo $product_category['category_id']; ?>">
								<h2 class="text-center"><?php echo$product_category['category_name']; ?></h2>
								<hr />
								<?php if(isset($product_category['products']) && count($product_category['products']) > 0) { ?>
									<?php foreach ($product_category['products'] as $product) { ?>
										<label class="checkbox-inline">
				                            <input type="checkbox" value="<?php echo $product['id']; ?>" name="product_ids[]" class="square-grey" <?php echo (in_array($product['id'], $supplier_product)) ? 'checked' : ''; ?>>
				                            <?php echo $product['name']; ?>
				                        </label>
									<?php } ?>
								<?php } else { echo '<strong class="text-danger">' , $this->lang->line('no_product_in_category'), '</strong>'; }?>
							</div>
						<?php } ?>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>