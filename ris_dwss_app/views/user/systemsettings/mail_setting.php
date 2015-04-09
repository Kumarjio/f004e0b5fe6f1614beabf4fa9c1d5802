<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#edit").validate();
    });
    //]]>
</script>
<?php $session = $this->session->userdata('user_session'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1>Mail Setting</h1>
        </div>
    </div>
</div
<div class="the-box">
    <form id="edit" method="post" class="form-horizontal" action="<?php echo USER_URL . 'system_setting/update_mail'; ?>">
        <?php foreach ($setting as $value) { ?>
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo ucfirst(str_replace('_', ' ', $value->sys_key)); ?> <span class="text-danger">*</span></label>
                <div class="col-lg-5">
                    <?php if ($value->sys_key == 'snmp_set_oid_output_format(   )pass') { ?>
                        <input type="password" name="<?php echo $value->sys_key; ?>"  class="form-control required" value="<?php echo $value->sys_value; ?>"/>
                    <?php } else { ?>
                        <input type="text" name="<?php echo $value->sys_key; ?>"  class="form-control required" value="<?php echo $value->sys_value; ?>"/>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>

        <div class="form-group">
            <label class="col-lg-2 control-label">&nbsp;</label>
            <div class="col-lg-8">
                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Update">Update</button>
                <a href="<?php echo USER_URL; ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="Cancel">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label">&nbsp;</label>
            <div class="col-lg-5">
                <?php echo $this->lang->line('compulsory_note'); ?>
            </div>
        </div>
    </form>
</div>