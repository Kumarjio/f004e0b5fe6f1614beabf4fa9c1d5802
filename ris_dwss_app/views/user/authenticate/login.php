<script>
    //<![CDATA[
    jQuery(document).ready(function() {
        jQuery("#login").validate({
            errorPlacement: function(){
                return false;
            }
        });
    });
    //]]>
</script>


<div class="box-login">
    <h3><?php echo $this->lang->line('sign_into_account'); ?></h3>
    <form class="form-login" id="login" action="<?php echo USER_URL .'validate'; ?>" method="post">
        <fieldset>
            <div class="form-group">
                <span class="input-icon">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                    <i class="icon-user"></i> </span>
            </div>
            <div class="form-group form-actions">
                <span class="input-icon">
                    <input type="password" class="form-control password" name="password" placeholder="Password">
                    <i class="icon-lock"></i>
                    <a class="forgot" href="<?php echo USER_URL .'forgot_password'; ?>">
                        <?php echo $this->lang->line('i_forgot_password'); ?>
                    </a> </span>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-bricky pull-right">
                    <?php echo $this->lang->line('login_button'); ?> <i class="icon-circle-arrow-right"></i>
                </button>
            </div>
        </fieldset>
    </form>
</div>