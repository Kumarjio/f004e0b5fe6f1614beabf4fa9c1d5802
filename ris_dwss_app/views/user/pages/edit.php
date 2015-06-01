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
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('page'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo USER_URL . 'page/edit/' . @$page->id; ?>" enctype="multipart/form-data">

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('page_content_title'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_title'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('page_content_title'), ' ', ucwords($value); ?>" value="<?php echo $page->{$key .'_title'}; ?>"/>
                    </div>
                </div>
            <?php } ?>

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('page_content_description'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <textarea name="<?php echo $key . '_description'; ?>"  class="summernote-sm <?php echo ($key == 'en') ? 'required' : ''; ?>"><?php echo $page->{$key .'_description'}; ?></textarea>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
                    <a href="<?php echo USER_URL . 'page' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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