<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery('.radio-checkbox-error').hide();
            jQuery.validator.setDefaults({ ignore: ":hidden:not(select)" });
            jQuery("#add").validate({
                rules: {
                    //password : {passwordpattern: true},
                    confirm_password: {equalTo: '#password'},
                    username: {nowhitespace: true, remote: '<?php echo USER_URL . "checkusername/". $user->id; ?>'},
                    email: {remote: '<?php echo USER_URL . "checkemail/". $user->id; ?>'},
                },
                messages: {
                    cpassword: {equalTo: '* Password does Not Match'},
                    username: {remote: '* Username already exit'},
                    email: {remote: '* Email already exit'},
                },
                errorPlacement: function(error, element) {
                    if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                        jQuery(element).parents().find('.radio-checkbox-error').show();
                        jQuery(element).parents().find('.radio-checkbox-error').html(error);
                    } else if (element.attr('id') === 'role_id') {
                        jQuery(element).parents().find('.select-error').show();
                        jQuery(element).parents().find('.select-error').html(error);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('edit') ,' ', $this->lang->line('user'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'user/edit/' . $user->id; ?>">

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label"><?php echo $this->lang->line('user_role'); ?></label>
                <div class="col-lg-9">
                    <select name="role_id" id="role_id" class="form-control chosen-select required" data-placeholder="<?php echo $this->lang->line('user_role'); ?>">
                        <option></option>
                        <?php foreach ($roles as $role) { ?>
                            <option value="<?php echo $role->id; ?>" <?php echo ($user->role_id == $role->id) ? 'selected' : ''; ?>><?php echo ucwords($role->name); ?></option>
                        <?php } ?>                        
                    </select>
                    <span class="select-error error" style="dispaly:none"></span>
                </div>
            </div>

            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo ucwords($value), ' ', $this->lang->line('user_name'); ?>
                        <span class="text-danger"><?php echo ($key == 'en') ? '*' : '&nbsp;'; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="<?php echo $key . '_fullname'; ?>"  class="<?php echo ($key == 'en') ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('user_name'), ' ', ucwords($value); ?>" value="<?php echo $user->{$key.'_fullname'}; ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_mobile'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="mobile"  class="form-control required" placeholder="<?php echo $this->lang->line('user_mobile'); ?>" value="<?php echo $user->mobile; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_email'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="email" name="email"  class="form-control" placeholder="<?php echo $this->lang->line('user_email'); ?>" value="<?php echo $user->email; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_username'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="text" name="username"  class="form-control required" placeholder="<?php echo $this->lang->line('user_username'); ?>" value="<?php echo $user->username; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_password'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo $this->lang->line('user_password'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('user_cnew_pwd'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="password" name="confirm_password"  class="form-control" placeholder="<?php echo $this->lang->line('user_cnew_pwd'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('status'); ?>
                </label>
                <div class="col-lg-9">
                    <label class="radio-inline">
                        <input type="radio" value="1" name="status" class="square-grey" <?php echo ($user->status == 1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('user_status_active'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="0" name="status" class="square-grey" <?php echo ($user->status == 0) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('user_status_inactive'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="2" name="status" class="square-grey" <?php echo ($user->status == 2) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('user_status_banned'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
                    <a href="<?php echo USER_URL . 'user' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
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