<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#forgot_password").validate({
            errorPlacement: function(){
                return false;
            }
        });
    });
    //]]>
</script>
<div class="box-login">
    <h3><?php echo $this->lang->line('forgot_password'); ?></h3>
    <form class="form-login" id="forgot_password" action="<?php echo USER_URL .'send_reset_password_link'; ?>" method="post">
        <fieldset>
            <div class="form-group">
                <span class="input-icon">
                    <input type="email" name="email" class="form-control required" placeholder="<?php echo $this->lang->line('email_address'); ?>"/>
                    <i class="icon-envelope-alt"></i>
                </span>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-green pull-right">
                    <?php echo $this->lang->line('send_mail'); ?>&nbsp;<i class="icon-circle-arrow-right"></i>
                </button>
                <a class="btn btn-dark-grey" href="<?php echo USER_URL .'login'; ?>"><i class="icon-circle-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_login'); ?></a>
            </div>
        </fieldset>
    </form>
</div>