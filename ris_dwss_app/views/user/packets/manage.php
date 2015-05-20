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

            <div class="packet-group">
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('packet'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="weight[0]" class="form-control required" placeholder="<?php echo $this->lang->line('packet_weight'); ?>" />
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
                        <input type="text" name="weight" class="form-control" placeholder="<?php echo $this->lang->line('packet_weight'); ?>"/>
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

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
                    <a href="<?php echo USER_URL . 'packet' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </div>
        </form>
    </div>
</div>
