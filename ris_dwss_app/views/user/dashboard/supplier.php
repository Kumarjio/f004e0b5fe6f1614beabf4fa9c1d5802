<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('dashboard'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
	<?php if (hasPermission('suppliers', 'manageProductSupplier')) { ?>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-list-3"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_supplier_product; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'supplier/product'; ?>" alt="<?php echo $this->lang->line('supplier_manage_product'); ?>" title="<?php echo $this->lang->line('supplier_manage_product'); ?>"><?php echo $this->lang->line('supplier_manage_product'); ?></a></label>
	            </div>
	        </div>
		</div>
    <?php } ?>

	<?php if (checkSuppliersupplierAmenities(4, $this->session_data->supplier_id) && hasPermission('selloffers', 'viewSelloffer')) {  ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class=" clip-bubble-4"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_selloffer; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'selloffer'; ?>" alt="<?php echo $this->lang->line('staff'); ?>" title="<?php echo $this->lang->line('selloffer'); ?>"><?php echo $this->lang->line('selloffer'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (checkSuppliersupplierAmenities(4, $this->session_data->supplier_id) && hasPermission('supplierrequriments', 'viewSupplierrequriment')) {  ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-bubbles-2"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_supplierrequriment; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'supplierrequriment'; ?>" alt="<?php echo $this->lang->line('staff'); ?>" title="<?php echo $this->lang->line('supplierrequriment'); ?>"><?php echo $this->lang->line('supplierrequriment'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (checkSuppliersupplierAmenities(2, $this->session_data->supplier_id) && hasPermission('advertisements', 'viewAdvertisement')) {  ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-wand"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_advertisement; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'advertisement'; ?>" alt="<?php echo $this->lang->line('staff'); ?>" title="<?php echo $this->lang->line('advertisement'); ?>"><?php echo $this->lang->line('advertisement'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>
</div>