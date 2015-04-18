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
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('add') ,' ', $this->lang->line('supplier'); ?></h1>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('file_errors') != '') { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="auto-close alert alert-danger fade in alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="text-center">
                    <?php echo $this->session->flashdata('file_errors'); ?>
                </p>
            </div>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'supplier/add'; ?>" enctype="multipart/form-data">

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_shop_no'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_shop_no'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_form_date'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_form_date'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_form_no'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_form_no'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_type'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <?php foreach ($suppliertypes as $suppliertype_value) { ?>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="<?php echo $suppliertype_value->id; ?>" name="suppliertype_id[]" class="square-grey">
                            <?php echo $suppliertype_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
            
            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('supplier_name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_name'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('supplier_name'), ' ', ucwords($value); ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_mobile'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_mobile'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_email'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="email" class="form-control" placeholder="<?php echo $this->lang->line('supplier_email'); ?>">
                </div>
            </div>

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('supplier_shop_name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_shop_name'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('supplier_shop_name'), ' ', ucwords($value); ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_owner_type'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="PO" name="owner" class="square-grey" checked>
                        <?php echo $this->lang->line('supplier_proprietary'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="PR" name="owner" class="square-grey">
                        <?php echo $this->lang->line('supplier_partnership'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_working_days'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="2" name="working_days" class="square-grey" checked>
                        <?php echo $this->lang->line('monday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="3" name="working_days" class="square-grey" checked>
                        <?php echo $this->lang->line('tuesday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="4" name="working_days" class="square-grey" checked>
                        <?php echo $this->lang->line('wednessday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="5" name="working_days" class="square-grey" checked>
                        <?php echo $this->lang->line('thursday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="6" name="working_days" class="square-grey" checked>
                        <?php echo $this->lang->line('friday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="7" name="working_days" class="square-grey" checked>
                        <?php echo $this->lang->line('saturday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="1" name="working_days" class="square-grey">
                        <?php echo $this->lang->line('sunday'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_working_timing'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_working_timing'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_establishment_year'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_establishment_year'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_payment_mode'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="cash" name="payment[]" class="square-grey" checked>
                        <?php echo $this->lang->line('supplier_payment_cash'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="check" name="payment[]" class="square-grey">
                        <?php echo $this->lang->line('supplier_payment_check'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="other" name="payment[]" class="square-grey">
                        <?php echo $this->lang->line('supplier_payment_other'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_website'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_website'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_bussiness_type'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <?php foreach ($supplierbusinesstypes as $supplierbusinesstype_value) { ?>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="<?php echo $supplierbusinesstype_value->id; ?>" name="suppliertype_id[]" class="square-grey">
                            <?php echo $supplierbusinesstype_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_no_employees'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_no_employees'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_sms_requriments'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="sms_requriment" class="square-grey" checked>
                        <?php echo $this->lang->line('yes'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="sms_requriment" class="square-grey">
                        <?php echo $this->lang->line('no'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_amenities'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <?php foreach ($supplieramenities as $supplieramenitie_value) { ?>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="<?php echo $supplieramenitie_value->id; ?>" name="suppliertype_id[]" class="square-grey">
                            <?php echo $supplieramenitie_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
                    <a href="<?php echo USER_URL . 'bod' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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