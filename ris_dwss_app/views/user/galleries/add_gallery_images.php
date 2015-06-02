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

            var $tmp_count = 1;
            $('#add').on('click', '.addButton', function() {
                $(this).parent().find('.removeButton').show();
                $(this).parent().find('.addButton').hide();
                var $template = $('#template-image-group'),
                    $clone    = $template
                                    .clone()
                                    .removeClass('hide')
                                    .removeAttr('id')
                                    .insertBefore($template),
                    $option   = $clone.find('.image-group');

                $(this).parents('.image-group').next().find('input[name="en_image_title"]').removeAttr('disabled');
                $(this).parents('.image-group').next().find('input[name="en_image_title"]').attr('name', 'en_image_title['+ $tmp_count +']');

                $(this).parents('.image-group').next().find('input[name="gu_image_title"]').removeAttr('disabled');
                $(this).parents('.image-group').next().find('input[name="gu_image_title"]').attr('name', 'gu_image_title['+ $tmp_count +']');

                $(this).parents('.image-group').next().find('input[name="image_file"]').removeAttr('disabled');
                $(this).parents('.image-group').next().find('input[name="image_file"]').attr('name', 'image_file['+ $tmp_count +']');

                $tmp_count++;
            });

            $('#add').on('click', '.removeButton', function() {
                $('.tooltip').remove();
                $(this).parents('.image-group').prev().find('.addButton').show();
                var $row    = $(this).parents('.image-group');
                $row.remove();
                $tmp_count--;
            })
        });
    //]]>

    function deletedata(ele) {
        var current_id = jQuery(ele).attr('id');
        var parent = jQuery(ele).parent().parent();
        var $this = jQuery(ele);

        swal(
            {
                title: "<?php echo $this->lang->line('manage_data'); ?>",
                text: "<?php echo $this->lang->line('do_you_want_to_delete'); ?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo $this->lang->line('yes_delete_action'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('no_delete_action'); ?>",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    jQuery.ajax({
                        type: 'POST',
                        url: http_host_js + 'image/delete/' + current_id,
                        data: id = current_id,
                        dataType : 'JSON',
                        success: function(data) {
                            if(data.status == 'success'){
                                jQuery('.tooltip').remove();
                                $this.parents('.old-image-group').remove();
                                swal("Deleted!", data.msg, "success");
                            }else{
                                swal("Error!", data.msg, "error");
                            }
                        }
                    });
                }
            }
        );
        return false;
    }
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('add') ,' ', $this->lang->line('gallery_image'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'gallery/add/image/' . $gallery_details->id; ?>" enctype="multipart/form-data">

            <div class="image-group">
                <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                    <div class="form-group">
                        <label for="question" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">
                            <?php echo ucwords($value), ' ', $this->lang->line('gallery_image_tile'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6">
                            <input type="text" name="<?php echo $key . '_image_title[0]'; ?>" class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('gallery_image_tile'), ' ', ucwords($value); ?>"/>
                        </div>
                        <?php if($key == 'en') { ?>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <button type="button" class="btn btn-success addButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add_gallery_image'); ?>"><i class="clip-plus-circle"></i></button>
                                <button type="button" class="btn btn-danger hide removeButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('remove_gallery_image'); ?>"><i class="clip-minus-circle"></i></button>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label for="question" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">
                        &nbsp;
                    </label>
                    <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6">
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
                                        <input type="file" class="file-input" name="image_file[0]">
                                    </div>
                                    <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                                        <i class="icon-remove"></i> <?php echo $this->lang->line('remove_image'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="template-image-group" class="image-group hide">
                <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                    <div class="form-group">
                        <label for="question" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">
                            <?php echo ucwords($value), ' ', $this->lang->line('gallery_image_tile'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6">
                            <input type="text" disabled="disabled" name="<?php echo $key . '_image_title'; ?>" class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('gallery_image_tile'), ' ', ucwords($value); ?>"/>
                        </div>
                        <?php if($key == 'en') { ?>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <button type="button" class="btn btn-success addButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add_gallery_image'); ?>"><i class="clip-plus-circle"></i></button>
                                <button type="button" class="btn btn-danger removeButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('remove_gallery_image'); ?>"><i class="clip-minus-circle"></i></button>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label for="question" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">
                        &nbsp;
                    </label>
                    <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6">
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
                                        <input type="file" class="file-input" disabled="disabled" name="image_file">
                                    </div>
                                    <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                                        <i class="icon-remove"></i> <?php echo $this->lang->line('remove_image'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                    <a href="<?php echo USER_URL . 'gallery/view/' . $gallery_details->id; ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="<?php echo PLUGIN_URL; ?>bootstrap-fileupload/bootstrap-fileupload.min.js"></script>