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

            jQuery('.date-picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
            });
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('markets'); ?></h1>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('file_errors') != '') { ?>
    <div class="row">
        <div class="auto-close alert alert-danger fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p class="text-center">
                <?php echo $this->session->flashdata('file_errors'); ?>
            </p>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo USER_URL . 'market/edit/' . $market->id; ?>" enctype="multipart/form-data">

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_name'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('markets'), ' ', $this->lang->line('name'), ' ', ucwords($value); ?>" value="<?php echo $market->{$key . '_name'} ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_type'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="type" class="form-control required" placeholder="<?php echo $this->lang->line('market_type'); ?>" value="<?php echo $market->type; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_date_establishment'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="etsd" class="form-control date-picker" placeholder="<?php echo $this->lang->line('market_date_establishment'); ?>" value="<?php echo ($market->etsd != '') ? date('d-m-Y', strtotime($market->etsd)) : ''; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_area_sq_mt'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="area_sq_mt" class="form-control" placeholder="<?php echo $this->lang->line('market_area_sq_mt'); ?>" value="<?php echo $market->area_sq_mt; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_area_acre'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="area_acre" class="form-control" placeholder="<?php echo $this->lang->line('market_area_acre'); ?>" value="<?php echo $market->area_acre; ?>"/>
                </div>
            </div>

            <?php if(!empty($market->image) && file_exists('assets/uploads/market_images/' . $market->image)){ ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('current_market_image'); ?>
                    </label>
                    <div class="col-lg-9">
                        <img src="<?php echo ASSETS_URL .'uploads/market_images/' . $market->image; ?>" alt="" class="img-thumbnail col-md-4">
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_image'); ?>
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
                                    <input type="file" class="file-input" name="market_image">
                                </div>
                                <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                                    <i class="icon-remove"></i> <?php echo $this->lang->line('remove_image'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_address'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <textarea name="address" class="form-control" rows="8" placeholder="<?php echo $this->lang->line('market_address'); ?>"><?php echo $market->address; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('market_status'); ?>
                </label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="status" class="square-grey" <?php echo ($market->status == 1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('active'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="status" class="square-grey" <?php echo ($market->status == 0) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('in_active'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
                    <a href="<?php echo USER_URL . 'market' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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