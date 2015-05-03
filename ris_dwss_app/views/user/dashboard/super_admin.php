<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('dashboard'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-sm-3 green">
	    <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="clip-star"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_markets; ?></var>
                <label class="text-muted">Markets</label>
            </div>
        </div>
	</div>
    <div class="col-sm-3">
        <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="clip-list-2"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_product_categories; ?></var>
                <label class="text-muted">Product Categories</label>
            </div>
        </div>
	</div>
    <div class="col-sm-3">
        <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="clip-list-3"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_products; ?></var>
                <label class="text-muted">Products</label>
            </div>
        </div>
	</div>
    <div class="col-sm-3">
        <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="clip-users"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_suppliers; ?></var>
                <label class="text-muted">Suppliers</label>
            </div>
        </div>
	</div>
</div>

<div class="row">
	<div class="col-sm-3 green">
	    <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="clip-note"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_news; ?></var>
                <label class="text-muted">News</label>
            </div>
        </div>
	</div>
    <div class="col-sm-3">
        <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="icon-copy"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_tenders; ?></var>
                <label class="text-muted">Tenders</label>
            </div>
        </div>
	</div>
    <div class="col-sm-3">
        <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="clip-users-2"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_bods; ?></var>
                <label class="text-muted">Board of Directories</label>
            </div>
        </div>
	</div>
    <div class="col-sm-3">
        <div class="hero-widget well well-sm">
            <div class="icon">
                 <i class="clip-users-3"></i>
            </div>
            <div class="text">
                <var><?php echo @$total_stafves; ?></var>
                <label class="text-muted">Saff</label>
            </div>
        </div>
	</div>
</div>