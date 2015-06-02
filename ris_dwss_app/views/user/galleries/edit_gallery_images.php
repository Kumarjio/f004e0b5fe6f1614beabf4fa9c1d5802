<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery("#edit").validate();
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('gallery_image'); ?></h1>
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
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'gallery/edit/image/' . $gallery_details->id .'/' . $gallery_image_details->id; ?>" enctype="multipart/form-data">

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('gallery_image_tile'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6">
                        <input type="text" name="<?php echo $key . '_image_title'; ?>" class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('gallery_image_tile'), ' ', ucwords($value); ?>" value="<?php echo $gallery_image_details->{$key .'_name'}; ?>"/>
                    </div>
                </div>
            <?php } ?>

            <?php if(!empty($gallery_image_details->image) && file_exists('assets/uploads/gallery_images/' . $gallery_image_details->image)){ ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('gallery_image'); ?>
                    </label>
                    <div class="col-lg-9">
                        <img src="<?php echo ASSETS_URL .'uploads/gallery_images/' . $gallery_image_details->image; ?>" alt="" class="img-thumbnail col-md-4">
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">
                    <?php echo $this->lang->line('gallery_image'); ?>
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
                                    <input type="file" class="file-input" name="image_file">
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
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                    <a href="<?php echo USER_URL . 'gallery/view/' . $gallery_details->id; ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="<?php echo PLUGIN_URL; ?>bootstrap-fileupload/bootstrap-fileupload.min.js"></script>