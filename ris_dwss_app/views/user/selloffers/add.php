<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery.validator.setDefaults({ ignore: ":hidden:not(select)" });
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

            jQuery('#supplier_id').change(function(){
                jQuery.ajax({
                    type: 'GET',
                    url: '<?php echo USER_URL ."get_product_by_supplier_selloffer/"; ?>' + jQuery('#supplier_id').val(),
                    success: function(data){
                        jQuery('#product_id').empty();
                        jQuery('#product_id').append(data);
                        jQuery("#product_id").trigger("chosen:updated");
                    }
                });
                jQuery(this).parent().find('.error').hide();
                jQuery('#product_id').parent().find('.error').hide();
            });

            jQuery('#product_id').change(function(){
                jQuery(this).parent().find('.error').remove();
            });

            jQuery('.summernote-sm').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });

            jQuery('.date-picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                startDate: '-0d'
            });
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('add') ,' ', $this->lang->line('selloffer'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'selloffer/add'; ?>">
            <?php if($this->session_data->role ==1 || $this->session_data->role ==2){  ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('selloffer_supplier'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-9">
                        <select name="supplier_id" id="supplier_id" class="required form-control chosen-select" data-placeholder="<?php echo $this->lang->line('selloffer_supplier'); ?>" required>
                            <option value=""></option>
                            <?php foreach ($supplier_details as $supplier) { ?>
                                <option value="<?php echo $supplier->id; ?>"><?php echo $supplier->shop_no .' - '. $supplier->{$session->language.'_shop_name'} ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('selloffer_product'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-9">
                        <select name="product_id" id="product_id" class="required form-control chosen-select" data-placeholder="<?php echo $this->lang->line('selloffer_product'); ?>">
                            <option value=""></option>
                            <?php foreach ($products_details as $products) { ?>
                                <optgroup label="<?php echo $products['category_name']; ?>">
                                    <?php foreach ($products['products'] as $product) { ?>
                                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                </div>


            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('selloffer_title'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_title'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('selloffer'), ' ', $this->lang->line('selloffer_title'), ' ', ucwords($value); ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('selloffer_start_date'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="start_date"  class="form-control required date-picker" placeholder="<?php echo $this->lang->line('selloffer_start_date'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('selloffer_end_date'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="end_date"  class="form-control required date-picker" placeholder="<?php echo $this->lang->line('selloffer_end_date'); ?>"/>
                </div>
            </div>

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('selloffer_description'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <textarea name="<?php echo $key . '_description'; ?>"  class="summernote-sm <?php echo ($key == 'en') ? 'required' : ''; ?>"></textarea>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_status'); ?>
                </label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="status" class="square-grey" checked>
                        <?php echo $this->lang->line('active'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="status" class="square-grey">
                        <?php echo $this->lang->line('in_active'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
                    <a href="<?php echo USER_URL . 'latestselloffer' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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
