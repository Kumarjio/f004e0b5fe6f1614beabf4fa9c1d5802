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
            <h1><?php echo $this->lang->line('advertisement_approve') ,' ', $this->lang->line('advertisement'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'advertisement/approve/'. $advertisement->id; ?>">
            
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

            <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('advertisement_remark'); ?>
                        <span class="text-danger">&nbsp</span>
                    </label>
                    <div class="col-lg-6">
                        <textarea name="remark" class="form-control" rows="5"></textarea>
                    </div>
                </div>

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
