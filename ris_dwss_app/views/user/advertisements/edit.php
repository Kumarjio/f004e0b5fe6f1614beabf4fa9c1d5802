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
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('advertisement'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'advertisement/edit/'. $advertisement->id; ?>" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label required">
                    <?php echo $this->lang->line('advertisement_place'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <select class="form-control chosen-select required" name="place">
                        <option value=""></option>
                    <?php foreach ($this->config->item('advertisement_places') as $p_key => $p_value) { ?>
                        <option value="<?php echo $p_key; ?>" <?php echo ($advertisement->place == $p_key) ? 'selected' : ''; ?>><?php echo $p_value[$session->language]; ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>

            <?php if($this->session_data->role ==1 || $this->session_data->role ==2){  ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('advertisement_shop_name'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-9">
                        <select class="form-control chosen-select required" name="supplier_id">
                            <option value=""></option>
                        <?php foreach ($suppliers as $s_value) { ?>
                            <option value="<?php echo $s_value->id; ?>" <?php echo ($advertisement->supplier_id == $s_value->id) ? 'selected' : ''; ?>><?php echo $s_value->{$session->language.'_shop_name'}; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            
            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('advertisement_name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_name'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('news'), ' ', $this->lang->line('advertisement_name'), ' ', ucwords($value); ?>" value="<?php echo $advertisement->{$key . '_name'} ?>"/>
                    </div>
                </div>
            <?php } ?>

            <?php if(!empty($advertisement->image) && file_exists('assets/uploads/advertisement_images/' . $advertisement->image)){ ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('advertisement_image'); ?>
                    </label>
                    <div class="col-lg-9">
                        <img src="<?php echo ASSETS_URL .'uploads/advertisement_images/' . $advertisement->image; ?>" alt="" class="img-thumbnail col-md-3">
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('advertisement_image'); ?>
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
                                    <input type="file" class="file-input" name="advertisement_image">
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
                    <?php echo $this->lang->line('advertisement_url'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="url"  class="form-control" placeholder="<?php echo $this->lang->line('advertisement_url'); ?>" value="<?php echo $advertisement->url; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('advertisement_start_date'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="start_date"  class="form-control required date-picker" placeholder="<?php echo $this->lang->line('advertisement_start_date'); ?>" value="<?php echo date('d-m-Y', strtotime($advertisement->start_date)); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('advertisement_end_date'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="end_date"  class="form-control required date-picker" placeholder="<?php echo $this->lang->line('advertisement_end_date'); ?>" value="<?php echo date('d-m-Y', strtotime($advertisement->end_date)); ?>"/>
                </div>
            </div>

            <?php if($this->session_data->role ==1 || $this->session_data->role ==2){  ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('status'); ?>
                    </label>
                    <div class="col-lg-9">
                        <label class="radio-inline">
                            <input type="radio" value="0" name="status" class="square-grey" <?php echo ($advertisement->status == 0) ? 'checked' : ''; ?>>
                            <?php echo $this->lang->line('pending'); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="1" name="status" class="square-grey" <?php echo ($advertisement->status == 1) ? 'checked' : ''; ?>>
                            <?php echo $this->lang->line('approved'); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="2" name="status" class="square-grey" <?php echo ($advertisement->status == 2) ? 'checked' : ''; ?>>
                            <?php echo $this->lang->line('unapproved'); ?>
                        </label>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
                    <a href="<?php echo USER_URL . 'advertisement' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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
