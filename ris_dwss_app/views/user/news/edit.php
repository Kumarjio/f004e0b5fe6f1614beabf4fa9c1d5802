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
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('news'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo USER_URL . 'latestnews/edit/' . $news->id; ?>" enctype="multipart/form-data">

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('news_name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_name'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('news'), ' ', $this->lang->line('news_name'), ' ', ucwords($value); ?>" value="<?php echo $news->{$key .'_name'}; ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('news_start_date'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="start_date" value="<?php echo date('d-m-Y', strtotime($news->start_date)); ?>" class="form-control required date-picker" placeholder="<?php echo $this->lang->line('news_start_date'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('news_end_date'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="end_date" value="<?php echo date('d-m-Y', strtotime($news->end_date)); ?>" class="form-control required date-picker" placeholder="<?php echo $this->lang->line('news_end_date'); ?>"/>
                </div>
            </div>

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('news_description'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <textarea name="<?php echo $key . '_description'; ?>"  class="summernote-sm <?php echo ($key == 'en') ? 'required' : ''; ?>"><?php echo $news->{$key .'_description'}; ?></textarea>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('news_status'); ?>
                </label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="status" class="square-grey" <?php echo ($news->status == 1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('active'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="status" class="square-grey" <?php echo ($news->status == 0) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('in_active'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
                    <a href="<?php echo USER_URL . 'latestnews' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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