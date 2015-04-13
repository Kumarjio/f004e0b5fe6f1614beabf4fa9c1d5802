<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#reset_password").validate({
            rules: {
                cnew_password: {equalTo: '#new_password'}
            },
            messages: {
                cnew_password: {equalTo: '* <?php echo $this->lang->line("both_pwd_not_match"); ?>'}
            }
        });
    });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('user_password'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="reset_password" method="post" class="form-horizontal" action="<?php echo USER_URL . 'password'; ?>">


            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_old_pwd'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="old_password" class="form-control" placeholder="<?php echo $this->lang->line('user_old_pwd'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_new_pwd'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="<?php echo $this->lang->line('user_new_pwd'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_cnew_pwd'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="cnew_password" class="form-control" placeholder="<?php echo $this->lang->line('user_cnew_pwd'); ?>"/>
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