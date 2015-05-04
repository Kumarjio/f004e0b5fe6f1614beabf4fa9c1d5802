<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('dashboard'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
	<?php if (hasPermission('markets', 'viewMarket')) { ?>
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
		    <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-star"></i>
	            </div>  
	            <div class="text">
	                <var><?php echo @$total_markets; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'market'; ?>" alt="<?php echo $this->lang->line('markets'); ?>" title="<?php echo $this->lang->line('markets'); ?>"><?php echo $this->lang->line('markets'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (hasPermission('productcategories', 'viewProductcategory')) { ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-list-2"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_product_categories; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'productcategory'; ?>" alt="<?php echo $this->lang->line('product_category'); ?>" title="<?php echo $this->lang->line('product_category'); ?>"><?php echo $this->lang->line('product_category'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (hasPermission('product', 'viewProduct')) { ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-list-3"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_products; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'product'; ?>" alt="<?php echo $this->lang->line('product'); ?>" title="<?php echo $this->lang->line('product'); ?>"><?php echo $this->lang->line('product'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (hasPermission('suppliers', 'viewSupplier')) { ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-users"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_suppliers; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'supplier'; ?>" alt="<?php echo $this->lang->line('supplier'); ?>" title="<?php echo $this->lang->line('supplier'); ?>"><?php echo $this->lang->line('supplier'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (hasPermission('latestnews', 'viewLatestnews')) { ?>
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
		    <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-note"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_news; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'news'; ?>" alt="<?php echo $this->lang->line('news'); ?>" title="<?php echo $this->lang->line('news'); ?>"><?php echo $this->lang->line('news'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (hasPermission('tenders', 'viewTender')) { ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="icon-copy"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_tenders; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'tender'; ?>" alt="<?php echo $this->lang->line('tender'); ?>" title="<?php echo $this->lang->line('tender'); ?>"><?php echo $this->lang->line('tender'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (hasPermission('bods', 'viewBod')) { ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
                 	<i class="clip-users-2"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_bods; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'bod'; ?>" alt="<?php echo $this->lang->line('bod'); ?>" title="<?php echo $this->lang->line('bod'); ?>"><?php echo $this->lang->line('bod'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>

	<?php if (hasPermission('stafves', 'viewStaff')) { ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	        <div class="hero-widget well well-sm">
	            <div class="icon">
	                 <i class="clip-users-3"></i>
	            </div>
	            <div class="text">
	                <var><?php echo @$total_stafves; ?></var>
	                <label class="text-muted"><a href="<?php echo USER_URL .'staff'; ?>" alt="<?php echo $this->lang->line('staff'); ?>" title="<?php echo $this->lang->line('staff'); ?>"><?php echo $this->lang->line('staff'); ?></a></label>
	            </div>
	        </div>
		</div>
	<?php } ?>
</div>