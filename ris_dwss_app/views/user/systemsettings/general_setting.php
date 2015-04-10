<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#edit").validate();
    });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1>General Setting</h1>
        </div>
    </div>
</div>

<?php $session = $this->session->userdata('user_session'); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form id="edit" method="post" class="form-horizontal" action="<?php echo USER_URL . 'system_setting/update_general'; ?>" enctype="multipart/form-data">
            <?php foreach ($setting as $value) { ?>
                <?php if ($value->sys_key == 'default_language') { ?>               
                    <div class="form-group">
                        <label for="question" class="col-lg-3 control-label"><?php echo ucfirst(str_replace('_', ' ', $value->sys_key)); ?> <span class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <?php $languages = $this->config->item('custom_languages'); ?>
                            <select name="default_language" class="form-control">
                                <?php foreach ($this->config->item('custom_languages') as $lang_key => $lang_value) { ?>
                                    <option value="<?php echo $lang_key; ?>" <?php echo ($value->sys_value == $lang_key) ? 'selected' : ''; ?>><?php echo ucwords($lang_value); ?></option>
                                <?php } ?>                        
                            </select>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="form-group">
                        <label for="question" class="col-lg-3 control-label"><?php echo ucfirst(str_replace('_', ' ', $value->sys_key)); ?> <span class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" name="<?php echo $value->sys_key; ?>"  class="form-control required" value="<?php echo $value->sys_value; ?>"/>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="form-group">
                <label class="col-lg-3 control-label">&nbsp;</label>
                <div class="col-lg-7">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                    <a href="<?php echo USER_URL; ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">&nbsp;</label>
                <div class="col-lg-7">
                    <?php echo $this->lang->line('compulsory_note'); ?>
                </div>
            </div>
        </form>
    </div>
</div>