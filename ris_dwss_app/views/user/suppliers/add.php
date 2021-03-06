<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery('.radio-checkbox-error').hide();
            jQuery("#add").validate({
                rules: {
                    confirm_password: {equalTo: '#password'},
                    username: {nowhitespace: true, remote: '<?php echo USER_URL . "checkusername/0"; ?>'},
                    email: {remote: '<?php echo USER_URL . "checkemail/0"; ?>'},
                },
                messages: {
                    cpassword: {equalTo: '* Password does Not Match'},
                    username: {remote: '* Username already exit'},
                    email: {remote: '* Email already exit'},
                },
                errorPlacement: function(error, element) {
                    if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                        jQuery(element).parents('.form-group').find('.radio-checkbox-error').show();
                        jQuery(element).parents('.form-group').find('.radio-checkbox-error').html(error);
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });

            jQuery('.date-picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                endDate: '+0d'
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
            <input type="hidden" name="form_no" value="<?php echo $form_no; ?>" />

            <legend>Supplier Shop Details</legend>
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_form_no'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" value="<?php echo $form_no; ?>" disabled="disabled" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_form_date'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="form_date" class="form-control required date-picker" placeholder="<?php echo $this->lang->line('supplier_form_date'); ?>" value="<?php echo date('d-m-Y', strtotime(get_current_date_time()->get_date_for_db())); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_select_market'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="market_id" id="market_id" class="form-control chosen-select" data-placeholder="<?php echo $this->lang->line('product_select_market'); ?>">
                    <option value=""></option>
                        <?php foreach ($markets as $market) { ?>
                            <option value="<?php echo $market->id; ?>"><?php echo ucwords($market->{$session->language.'_name'}); ?></option>
                        <?php } ?>                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_shop_no'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="shop_no" class="form-control required" placeholder="<?php echo $this->lang->line('supplier_shop_no'); ?>">
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
                            <input type="checkbox" value="<?php echo $suppliertype_value->id; ?>" name="suppliertype_id[]" class="square-grey required">
                            <?php echo $suppliertype_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                    <div class="radio-checkbox-error"></div>
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
                        <input type="radio" value="PO" name="owner" class="square-grey required" checked>
                        <?php echo $this->lang->line('supplier_proprietary'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="PR" name="owner" class="square-grey required">
                        <?php echo $this->lang->line('supplier_partnership'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_working_days'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="2" name="working_days[]" class="square-grey required" checked>
                        <?php echo $this->lang->line('monday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="3" name="working_days[]" class="square-grey required" checked>
                        <?php echo $this->lang->line('tuesday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="4" name="working_days[]" class="square-grey required" checked>
                        <?php echo $this->lang->line('wednessday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="5" name="working_days[]" class="square-grey required" checked>
                        <?php echo $this->lang->line('thursday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="6" name="working_days[]" class="square-grey required" checked>
                        <?php echo $this->lang->line('friday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="7" name="working_days[]" class="square-grey required" checked>
                        <?php echo $this->lang->line('saturday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="1" name="working_days[]" class="square-grey required">
                        <?php echo $this->lang->line('sunday'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_working_timing'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="working_time" placeholder="<?php echo $this->lang->line('supplier_working_timing'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_establishment_year'); ?><span class="text-danger">&nbsp;</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('supplier_establishment_year'); ?>" name="estd_year">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_payment_mode'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="cash" name="payment[]" class="square-grey required" checked>
                        <?php echo $this->lang->line('supplier_payment_cash'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="check" name="payment[]" class="square-grey required">
                        <?php echo $this->lang->line('supplier_payment_check'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="other" name="payment[]" class="square-grey required">
                        <?php echo $this->lang->line('supplier_payment_other'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_website'); ?><span class="text-danger">&nbsp;</span></label>
                <div class="col-lg-9">
                    <input type="text" name="website" class="form-control" placeholder="<?php echo $this->lang->line('supplier_website'); ?>">
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
                            <input type="checkbox" value="<?php echo $supplierbusinesstype_value->id; ?>" name="supplierbusinesstype_id[]" class="square-grey required">
                            <?php echo $supplierbusinesstype_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                    <div class="radio-checkbox-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_no_employees'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="no_employees" class="form-control required" placeholder="<?php echo $this->lang->line('supplier_no_employees'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_sms_requriments'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="sms_requriment" class="square-grey required" checked>
                        <?php echo $this->lang->line('yes'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="sms_requriment" class="square-grey required">
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
                            <input type="checkbox" value="<?php echo $supplieramenitie_value->id; ?>" name="supplieramenity_id[]" class="square-grey">
                            <?php echo $supplieramenitie_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                    <div class="radio-checkbox-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_shop_image'); ?>
                </label>
                <div class="col-lg-9">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-group">
                            <div class="form-control uneditable-input">
                                <i class="icon-file fileupload-exists"></i>
                                <span class="fileupload-preview"></span>
                            </div>
                            <div class="input-group-btn">
                                <div class="btn btn-light-grey btn-file">
                                    <span class="fileupload-new"><i class="icon-folder-open-alt"></i> <?php echo $this->lang->line('select_image'); ?></span>
                                    <span class="fileupload-exists"><i class="icon-folder-open-alt"></i> <?php echo $this->lang->line('change_image'); ?></span>
                                    <input type="file" class="file-input" name="supplier_shop_image">
                                </div>
                                <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                                    <i class="icon-remove"></i> <?php echo $this->lang->line('remove_image'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <legend>Supplier Details</legend>
            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('supplier_name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_fullname'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('supplier_name'), ' ', ucwords($value); ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_mobile'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="mobile"  class="form-control required" placeholder="<?php echo $this->lang->line('supplier_mobile'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_email'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="email" name="email"  class="form-control" placeholder="<?php echo $this->lang->line('supplier_email'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_username'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="username"  class="form-control required" placeholder="<?php echo $this->lang->line('supplier_username'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_password'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="password" id="password" class="form-control required" placeholder="<?php echo $this->lang->line('supplier_password'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_confirm_password'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="confirm_password"  class="form-control required" placeholder="<?php echo $this->lang->line('supplier_confirm_password'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
                    <a href="<?php echo USER_URL . 'supplier' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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