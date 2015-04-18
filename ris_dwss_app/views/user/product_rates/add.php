<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery("#add").validate({
                errorPlacement: function(error, element) {
                    if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                        error.appendTo(element.parent());
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });

            jQuery('#market_id').change(function(){
                jQuery.ajax({
                    type: 'GET',
                    url: '<?php echo USER_URL ."get_product_category_by_market/"; ?>' + $('#market_id').val(),
                    success: function(data){
                        jQuery('#productcategory_id').empty();
                        jQuery('#productcategory_id').append(data);
                        jQuery("#productcategory_id").trigger("chosen:updated");
                    }
                });
            });

            jQuery('#rate_label').hide();
            jQuery('#productcategory_id').change(function(){
                jQuery.ajax({
                    type: 'GET',
                    url: '<?php echo USER_URL ."get_product_by_category_for_rate/"; ?>' + $('#productcategory_id').val(),
                    success: function(data){
                        jQuery('#rate_table').empty();
                        jQuery('#rate_table').append(data);
                        jQuery('#rate_label').show();
                    }
                });
            });
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('add') ,' ', $this->lang->line('product_rate'); ?></h1>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'productrate/add'; ?>">

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('product_category_select_market'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="market_id" id="market_id" class="form-control chosen-select" data-placeholder="<?php echo $this->lang->line('product_category_select_market'); ?>">
                        <option value=""></option>
                        option
                        <?php foreach ($markets as $market) { ?>
                            <option value="<?php echo $market->id; ?>"><?php echo ucwords($market->{$session->language.'_name'}); ?></option>
                        <?php } ?>                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('product_select_category'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="productcategory_id" id="productcategory_id" class="form-control chosen-select" data-placeholder="<?php echo $this->lang->line('product_select_category'); ?>">
                    <option value=""></option>
                    option
                    </select>
                </div>
            </div>

            <div class="form-group" id="rate_label">
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

            <div id="rate_table">
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
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