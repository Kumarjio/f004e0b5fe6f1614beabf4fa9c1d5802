<?php $session = $this->session->userdata('user_session'); ?>
<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();

        jQuery('#status').change(function(){
            loadDatatable();    
        });
    });

    function loadDatatable(){
        if(typeof dTable!='undefined'){dTable.fnDestroy();}
        
        dTable=jQuery('#list_data').dataTable({
            "language": {
                "url": "<?php echo PLUGIN_URL .'datatables/lang/' . $session->language .'.json'; ?>"
            },
            "bProcessing": true,
            "aLengthMenu": [ [<?php echo $this->config->item('data_table_length'); ?>], [<?php echo $this->config->item('data_table_length'); ?>] ],
            'iDisplayLength': <?php $lengths = explode(',', $this->config->item('data_table_length'));
            echo $lengths[0]; ?>,
            "bServerSide" : true,
            "aoColumns": [
                {"sClass": ""},{"sClass": "text-center"},{"sClass": "text-center"},
                {"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'supplierrequriment/sms/getjson?id=' . $supplierrequriment->id .'&status='; ?>" + jQuery('#status').val(),
        });
    }

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
                        url: http_host_js + 'supplierrequriment/sms/delete/' + current_id,
                        data: id = current_id,
                        dataType : 'JSON',
                        success: function(data) {
                            if(data.status == 'success'){
                                loadDatatable();
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

    function resendsms(ele) {
        var current_id = jQuery(ele).attr('id');
        var parent = jQuery(ele).parent().parent();
        var $this = jQuery(ele);

        swal(
            {
                title: "<?php echo $this->lang->line('supplierrequriment_resendsms'); ?>",
                text: "<?php echo $this->lang->line('do_you_want_to_resend_sms'); ?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo $this->lang->line('yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('no'); ?>",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    jQuery.ajax({
                        type: 'POST',
                        url: http_host_js + 'supplierrequriment/sms/resend/' + current_id,
                        data: id = current_id,
                        dataType : 'JSON',
                        success: function(data) {
                            if(data.status == 'success'){
                                loadDatatable();
                                swal("Success!", data.msg, "success");
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
    <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
        <div class="page-header">
            <h1><?php echo $this->lang->line('supplierrequriment_listsms'); ?></h1>
        </div>
    </div>

    <?php if (hasPermission('supplierrequriments', 'sendSmsSupplierrequriment')) { ?>
        <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
            <div class="page-header text-right">
                <h1><a class="btn btn-green" href="<?php echo USER_URL . 'supplierrequriment/sms/send/' . $supplierrequriment->id; ?>" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('supplierrequriment_sendsms'); ?>"><i class="clip-plus-circle"></i>&nbsp;<?php echo $this->lang->line('supplierrequriment_sendsms'); ?></a></h1>
            </div>
        </div>
    <?php } ?>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="icon-cog"></i> <?php echo $this->lang->line('filters'); ?>
        <div class="panel-tools">
            <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
            <a class="btn btn-xs btn-link panel-close" href="#">
                <i class="icon-remove"></i>
            </a>
        </div>
    </div>
    <div class="panel-body">   
        <div class="row">
            <div class="col-sm-12 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('status'); ?></label>
                    <div>
                        <select id="status" class="form-control chosen-select">
                            <option value="null">All</option>
                            <option value="1"><?php echo $this->lang->line('delivered'); ?></option>
                            <option value="0"><?php echo $this->lang->line('not_delivered'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="icon-cog"></i> <?php echo $this->lang->line('list'); ?>
        <div class="panel-tools">
            <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
            <a class="btn btn-xs btn-link panel-close" href="#">
                <i class="icon-remove"></i>
            </a>
        </div>
    </div>
    <div class="panel-body">                                    
        <div id="mainpanel" class="box-body table-responsive">
            <table class="table table-bordered table-hover" id="list_data">
                <thead class="the-box dark full">
                    <tr align="left">
                        <th><?php echo $this->lang->line('supplierrequriment_title'); ?></th>
                        <th width="100"><?php echo $this->lang->line('supplierrequriment_mobile_no'); ?></th>
                        <th width="100"><?php echo $this->lang->line('supplierrequriment_status'); ?></th>
                        <th width="150"><?php echo $this->lang->line('actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"><i><?php echo $this->lang->line('loading'); ?></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>