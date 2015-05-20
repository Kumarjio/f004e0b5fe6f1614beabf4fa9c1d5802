<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
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

            var $tmp_count = 1;
            $('#add').on('click', '.addButton', function() {
                $(this).parent().find('.removeButton').show();
                $(this).parent().find('.addButton').hide();
                var $template = $('#template-packet-group'),
                    $clone    = $template
                                    .clone()
                                    .removeClass('hide')
                                    .removeAttr('id')
                                    .insertBefore($template),
                    $option   = $clone.find('.packet-group');

                $(this).parents('.packet-group').next().find('input[name="weight"]').removeAttr('disabled');
                $(this).parents('.packet-group').next().find('input[name="weight"]').attr('name', 'weight['+ $tmp_count +']');
                $(this).parents('.packet-group').next().find('input[name="measurement"]').attr('name', 'measurement['+ $tmp_count +']');

                $(this).parents('.packet-group').next().find('input[type="text"]').addClass('Rana');

                $(this).parents('.packet-group').next().find('input[type="radio"]').iCheck({
                    radioClass: 'iradio_square-grey',
                    increaseArea: '10%' // optional
                });

                $tmp_count++;
            });

            $('#add').on('click', '.removeButton', function() {
                $('.tooltip').remove();
                $(this).parents('.packet-group').prev().find('.addButton').show();
                var $row    = $(this).parents('.packet-group');
                $row.remove();
            })
        });
    //]]>

    function deletedata(ele) {
        var current_id = jQuery(ele).attr('id');
        var parent = jQuery(ele).parent().parent();
        var $this = jQuery(ele);

        swal(
            {
                title: "<?php echo $this->lang->line('manage_data'); ?>",
                text: "<?php echo $this->lang->line('do_you_want_to_delete'); ?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo $this->lang->line('yes_delete_action'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('no_delete_action'); ?>",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    jQuery.ajax({
                        type: 'POST',
                        url: http_host_js + 'packet/delete/' + current_id,
                        data: id = current_id,
                        dataType : 'JSON',
                        success: function(data) {
                            if(data.status == 'success'){
                                jQuery('.tooltip').remove();
                                $this.parents('.old-packet-group').remove();
                                swal("Deleted!", data.msg, "success");
                            }else{
                                swal("Error!", data.msg, "error");
                            }
                        }
                    });
                }
            }
        );
        return false;
    }
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('manage') ,' ', $this->lang->line('packet'), ': ', $product_details->{$session->language.'_name'}; ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'packet/manage/' . $product_details->id; ?>">

        <legend><?php echo $this->lang->line('manage_add_new_packets'); ?></legend>
            <?php $required = ($packets_details->result_count() <= 0) ? 'required' : ''; ?>
            <div class="packet-group">
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('packet'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="weight[0]" class="form-control <?php echo $required; ?>" placeholder="<?php echo $this->lang->line('packet_weight'); ?>" />
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-success addButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add_packet'); ?>"><i class="clip-plus-circle"></i></button>
                        <button type="button" class="btn btn-danger hide removeButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('delete_packet'); ?>"><i class="clip-minus-circle"></i></button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        &nbsp;
                    </label>
                    <div class="col-lg-6">
                        <?php foreach ($this->config->item('packet_measurements') as $p_key => $p_value) { ?>
                            <label class="radio-inline">
                                <input type="radio" value="<?php echo $p_key; ?>" name="measurement[0]" class="square-grey" />
                                <?php echo $p_value[$session->language]; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div id="template-packet-group" class="packet-group hide">
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('packet'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" disabled="disabled" name="weight" class="form-control <?php echo $required; ?>" placeholder="<?php echo $this->lang->line('packet_weight'); ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-success addButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add_packet'); ?>"><i class="clip-plus-circle"></i></button>
                        <button type="button" class="btn btn-danger removeButton" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('delete_packet'); ?>"><i class="clip-minus-circle"></i></button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        &nbsp;
                    </label>
                    <div class="col-lg-6">
                        <?php foreach ($this->config->item('packet_measurements') as $p_key => $p_value) { ?>
                            <label class="radio-inline">
                                <input type="radio" value="<?php echo $p_key; ?>" name="measurement" />
                                <?php echo $p_value[$session->language]; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php if($packets_details->result_count() > 0) { ?>
                <legend><?php echo $this->lang->line('manage_old_packets'); ?></legend>
                <?php foreach ($packets_details as $packet) { ?>
                    <div class="old-packet-group">
                        <div class="form-group">
                            <label for="question" class="col-lg-2 control-label">
                                <?php echo $this->lang->line('packet'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="hidden" name="old_id[]" value="<?php echo $packet->id; ?>"/>
                                <input type="text" name="old_weight[<?php echo $packet->id; ?>]" class="form-control required" placeholder="<?php echo $this->lang->line('packet_weight'); ?>" value="<?php echo $packet->weight; ?>"/>
                            </div>
                            <div class="col-lg-2">
                                <a onclick="deletedata(this)" id="<?php echo $packet->id; ?>" class="btn btn-danger" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('delete_packet'); ?>"><i class="clip-minus-circle"></i></a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="question" class="col-lg-2 control-label">
                                &nbsp;
                            </label>
                            <div class="col-lg-6">
                                <?php foreach ($this->config->item('packet_measurements') as $p_key => $p_value) { ?>
                                    <label class="radio-inline">
                                        <input type="radio" value="<?php echo $p_key; ?>" name="old_measurement[<?php echo $packet->id; ?>]" class="square-grey" <?php echo ($packet->measurement == $p_key) ? 'checked' : '';?>/>
                                        <?php echo $p_value[$session->language]; ?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                    <a href="<?php echo USER_URL . 'packet' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </div>
        </form>
    </div>
</div>
