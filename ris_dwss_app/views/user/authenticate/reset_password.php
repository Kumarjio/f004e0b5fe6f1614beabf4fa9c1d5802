<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#reset_password").validate({
            rules: {
                new_cpassword: {equalTo: '#new_password'}
            },
            messages: {
                new_cpassword: {equalTo: '* <?php echo $this->lang->line("password_dose_not_match"); ?>'}
            }
        });
    });
    //]]>
</script>

<div class="box-login">
    <h3><?php echo $this->lang->line('reset_password'); ?></h3>
    <form class="form-login" id="reset_password" action="<?php echo USER_URL . 'reset_password/' . $random_string; ?>" method="post">
        <fieldset>
            <div class="form-group">
                <span class="input-icon">
                    <input type="password" name="new_password" id="new_password" class="form-control required" placeholder="<?php echo $this->lang->line('enter_password'); ?>"/>
                    <i class="icon-lock"></i>
                </span>
            </div>
            <div class="form-group">
                <span class="input-icon">
                    <input type="password" name="new_cpassword" class="form-control required" placeholder="<?php echo $this->lang->line('re_enter_password'); ?>"/>
                    <i class="icon-lock"></i>
                </span>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-green pull-right">
                    <?php echo $this->lang->line('reset_password'); ?>&nbsp;<i class="icon-circle-arrow-right"></i>
                </button>
            </div>
        </fieldset>
    </form>
</div>