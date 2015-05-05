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
                    url: '<?php echo USER_URL ."get_product_by_supplier_supplierrequriment/"; ?>' + jQuery('#supplier_id').val(),
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
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('supplierrequriment'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'supplierrequriment/edit/' . $supplierrequriment->id; ?>">
            <?php if($this->session_data->role ==1 || $this->session_data->role ==2){  ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('supplierrequriment_supplier'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-9">
                        <select name="supplier_id" id="supplier_id" class="required form-control chosen-select" data-placeholder="<?php echo $this->lang->line('supplierrequriment_supplier'); ?>" required>
                            <option value=""></option>
                            <?php foreach ($supplier_details as $supplier) { ?>
                                <option value="<?php echo $supplier->id; ?>" <?php echo ($supplierrequriment->supplier_id ==$supplier->id) ? 'selected' : ''; ?>><?php echo $supplier->shop_no .' - '. $supplier->{$session->language.'_shop_name'} ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('supplierrequriment_product'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-9">
                        <select name="product_id" id="product_id" class="required form-control chosen-select" data-placeholder="<?php echo $this->lang->line('supplierrequriment_product'); ?>">
                            <option value=""></option>
                            <?php foreach ($products_details as $products) { ?>
                                <optgroup label="<?php echo $products['category_name']; ?>">
                                    <?php foreach ($products['products'] as $product) { ?>
                                        <option value="<?php echo $product['id']; ?>" <?php echo ($supplierrequriment->product_id == $product['id']) ? 'selected' : ''; ?>><?php echo $product['name']; ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                </div>


            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('supplierrequriment_title'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_title'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('supplierrequriment'), ' ', $this->lang->line('supplierrequriment_title'), ' ', ucwords($value); ?>" value="<?php echo $supplierrequriment->{$key.'_title'} ?>"/>
                    </div>
                </div>
            <?php } ?>

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('supplierrequriment_description'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <textarea name="<?php echo $key . '_description'; ?>"  class="summernote-sm <?php echo ($key == 'en') ? 'required' : ''; ?>"><?php echo $supplierrequriment->{$key.'_description'} ?>"</textarea>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_status'); ?>
                </label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="status" class="square-grey" <?php echo ($supplierrequriment->status == 1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('active'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="status" class="square-grey" <?php echo ($supplierrequriment->status == 0) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('in_active'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
                    <a href="<?php echo USER_URL . 'supplierrequriment' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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