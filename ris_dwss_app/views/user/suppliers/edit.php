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
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('supplier'); ?></h1>
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
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'supplier/edit/' . $supplier->id; ?>" enctype="multipart/form-data">

            <legend>Supplier Shop Details</legend>
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_form_no'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" value="<?php echo $supplier->form_no; ?>" disabled="disabled" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_form_date'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="form_date" class="form-control required" placeholder="<?php echo $this->lang->line('supplier_form_date'); ?>" value="<?php echo date('d-m-Y', strtotime($supplier->form_date)); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_select_market'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select name="market_id" class="form-control chosen-select" data-placeholder="<?php echo $this->lang->line('product_select_market'); ?>">
                        <?php foreach ($markets as $market) { ?>
                            <option value="<?php echo $market->id; ?>" <?php echo($supplier->market_id == $market->id) ? 'selected' : ''; ?>><?php echo ucwords($market->{$session->language.'_name'}); ?></option>
                        <?php } ?>                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_shop_no'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="shop_no" class="form-control required" placeholder="<?php echo $this->lang->line('supplier_shop_no'); ?>" value="<?php echo $supplier->shop_no; ?>">
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
                            <input type="checkbox" value="<?php echo $suppliertype_value->id; ?>" name="suppliertype_id[]" class="square-grey required" <?php echo (in_array($suppliertype_value->id, explode(',', $supplier->suppliertype_id))) ? 'checked' : ''; ?>>
                            <?php echo $suppliertype_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('supplier_shop_name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_shop_name'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('supplier_shop_name'), ' ', ucwords($value); ?>" value="<?php echo $supplier->{$key .'_shop_name'} ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_owner_type'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="PO" name="owner" class="square-grey required" <?php echo ($supplier->owner == 'PO') ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('supplier_proprietary'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="PR" name="owner" class="square-grey required" <?php echo ($supplier->owner == 'PR') ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('supplier_partnership'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_working_days'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="2" name="working_days[]" class="square-grey required" <?php echo (in_array(2, explode(',', $supplier->working_days))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('monday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="3" name="working_days[]" class="square-grey required" <?php echo (in_array(3, explode(',', $supplier->working_days))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tuesday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="4" name="working_days[]" class="square-grey required" <?php echo (in_array(4, explode(',', $supplier->working_days))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('wednessday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="5" name="working_days[]" class="square-grey required" <?php echo (in_array(5, explode(',', $supplier->working_days))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('thursday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="6" name="working_days[]" class="square-grey required" <?php echo (in_array(6, explode(',', $supplier->working_days))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('friday'); ?>
                    </label>

                    <label class="checkbox-inline">
                        <input type="checkbox" value="7" name="working_days[]" class="square-grey required" <?php echo (in_array(7, explode(',', $supplier->working_days))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('saturday'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="1" name="working_days[]" class="square-grey required" <?php echo (in_array(1, explode(',', $supplier->working_days))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('sunday'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_working_timing'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="working_time" placeholder="<?php echo $this->lang->line('supplier_working_timing'); ?>" value="<?php echo $supplier->working_time; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_establishment_year'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control required" placeholder="<?php echo $this->lang->line('supplier_establishment_year'); ?>" name="estd_year" value="<?php echo $supplier->estd_year; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_payment_mode'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="cash" name="payment[]" class="square-grey required" <?php echo (in_array('cash', explode(',', $supplier->payment))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('supplier_payment_cash'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="check" name="payment[]" class="square-grey required" <?php echo (in_array('check', explode(',', $supplier->payment))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('supplier_payment_check'); ?>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="other" name="payment[]" class="square-grey required" <?php echo (in_array('other', explode(',', $supplier->payment))) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('supplier_payment_other'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_website'); ?><span class="text-danger">&nbsp;</span></label>
                <div class="col-lg-9">
                    <input type="text" name="website" class="form-control" placeholder="<?php echo $this->lang->line('supplier_website'); ?>" value="<?php echo $supplier->website; ?>">
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
                            <input type="checkbox" value="<?php echo $supplierbusinesstype_value->id; ?>" name="supplierbusinesstype_id[]" class="square-grey required" <?php echo (in_array($supplierbusinesstype_value->id, explode(',', $supplier->supplierbusinesstype_id))) ? 'checked' : ''; ?>>
                            <?php echo $supplierbusinesstype_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_no_employees'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="no_employees" class="form-control required" placeholder="<?php echo $this->lang->line('supplier_no_employees'); ?>" value="<?php echo $supplier->no_employees; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('supplier_sms_requriments'); ?><span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="sms_requriment" class="square-grey required" <?php echo ($supplier->sms_requriment == 1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('yes'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="sms_requriment" class="square-grey required" <?php echo ($supplier->sms_requriment == 0) ? 'checked' : ''; ?>>
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
                            <input type="checkbox" value="<?php echo $supplieramenitie_value->id; ?>" name="supplieramenity_id[]" class="square-grey" <?php echo (in_array($supplieramenitie_value->id, explode(',', $supplier->supplieramenity_id))) ? 'checked' : ''; ?>>
                            <?php echo $supplieramenitie_value->{$session->language.'_name'}; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <?php if(!empty($supplier->image) && file_exists('assets/uploads/supplier_shop_image/thumb/' . $supplier->image)){ ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('current_supplier_shop_image'); ?>
                    </label>
                    <div class="col-lg-9">
                        <img src="<?php echo ASSETS_URL .'uploads/supplier_shop_image/thumb/' . $supplier->image; ?>" alt="" class="img-thumbnail col-md-3">
                    </div>
                </div>
            <?php } ?>

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
                        <input type="text" name="<?php echo $key . '_fullname'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('supplier_name'), ' ', ucwords($value); ?>" value="<?php echo $user_details->{$key .'_fullname'} ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_mobile'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="mobile"  class="form-control required" placeholder="<?php echo $this->lang->line('supplier_mobile'); ?>" value="<?php echo $user_details->mobile; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_email'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="email"  class="form-control required" placeholder="<?php echo $this->lang->line('supplier_email'); ?>" value="<?php echo $user_details->email; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_username'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="username"  class="form-control required" placeholder="<?php echo $this->lang->line('supplier_username'); ?>" value="<?php echo $user_details->username;  ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_password'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo $this->lang->line('supplier_password'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplier_confirm_password'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="confirm_password"  class="form-control password" placeholder="<?php echo $this->lang->line('supplier_confirm_password'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
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