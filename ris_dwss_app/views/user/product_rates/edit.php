<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery("#edit").validate({
                errorPlacement: function(error, element) {
                    if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                        error.appendTo(element.parent());
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('product_rate'); ?></h1>
        </div>
    </div>
</div
<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo USER_URL . 'productrate/edit/' . $productrate->id; ?>" enctype="multipart/form-data">

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('product_category_select_market'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" value="<?php echo $product_market->{$session->language .'_name'}; ?>" disabled="disabled" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('product_select_category'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" value="<?php echo $product_category->{$session->language .'_name'}; ?>" disabled="disabled" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('product_rate_date'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" value="<?php echo date('d-m-Y', strtotime($productrate->date)); ?>" disabled="disabled" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for=""><?php echo $this->lang->line('product_rate_min'); ?></label>
                        </div>
                        <div class="col-lg-4">
                            <label for=""><?php echo $this->lang->line('product_rate_max'); ?></label>
                        </div>
                        <div class="col-lg-4">
                            <label for=""><?php echo $this->lang->line('product_rate_income'); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $product->{$session->language .'_name'}; ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="text" name="min_rate" value="<?php echo $productrate->min_rate; ?>" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <input type="text" name="max_rate" value="<?php echo $productrate->max_rate; ?>" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <input type="text" name="income" value="<?php echo $productrate->income; ?>" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
                    <a href="<?php echo USER_URL . 'productrate' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <?php echo $this->lang->line('compulsory_note'); ?>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo PLUGIN_URL; ?>bootstrap-fileupload/bootstrap-fileupload.min.js"></script>