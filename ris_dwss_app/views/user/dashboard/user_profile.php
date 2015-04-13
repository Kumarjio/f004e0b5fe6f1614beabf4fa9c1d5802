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
            <h1><?php echo $this->lang->line('user_profile'); ?></h1>
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
        <form id="edit" method="post" class="form-horizontal" action="<?php echo USER_URL . 'profile'; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_fullname'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="fullname" class="form-control required" placeholder="<?php echo $this->lang->line('user_fullname'); ?>" value="<?php echo $session->fullname; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_username'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="username" class="form-control required" placeholder="<?php echo $this->lang->line('user_username'); ?>" value="<?php echo $session->username; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_email'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="email" name="email" class="form-control" placeholder="<?php echo $this->lang->line('user_email'); ?>" value="<?php echo $session->email; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_mobile'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="mobile" class="form-control" placeholder="<?php echo $this->lang->line('user_mobile'); ?>" value="<?php echo $session->mobile; ?>"/>
                </div>
            </div>



            <?php if(!empty($session->profile_pic) && $session->profile_pic != 'no-avtar.png' && file_exists('./assets/uploads/user_images/' . $session->profile_pic)){ ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('user_current_image'); ?>
                    </label>
                    <div class="col-lg-9">
                        <img src="<?php echo ASSETS_URL .'uploads/user_images/' . $session->profile_pic; ?>" alt="" class="img-thumbnail col-md-3">
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_image'); ?>
                    <span class="text-danger">&nbsp;</span>
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
                                    <input type="file" class="file-input" name="user_image">
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
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
                    <a href="<?php echo USER_URL; ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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