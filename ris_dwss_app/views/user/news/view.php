<?php $session = $this->session->userdata('user_session'); ?>
<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();

        jQuery('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        jQuery('#status').change(function(){
            loadDatatable();    
        });

        jQuery('#start_date').change(function(){
            loadDatatable();    
        });

        jQuery('#end_date').change(function(){
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
                {"sClass": ""},{"sClass": ""},{"sClass": ""},
                {"sClass": "text-center"},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'news/getjson?status='; ?>" + jQuery('#status').val() + '&start_date=' + jQuery('#start_date').val() + '&end_date=' + jQuery('#end_date').val(),
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
                        url: http_host_js + 'latestnews/delete/' + current_id,
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
</script>

<div class="row">
    <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
        <div class="page-header">
            <h1><?php echo $this->lang->line('list') ,' ', $this->lang->line('news'), ' ('. @$count .')'; ?></h1>
        </div>
    </div>

    <?php if (hasPermission('latestnews', 'addLatestnews')) { ?>
        <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
            <div class="page-header text-right">
                <h1><a class="btn btn-green" href="<?php echo USER_URL . 'latestnews/add'; ?>" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('add'); ?>"><i class="clip-plus-circle"></i>&nbsp;<?php echo $this->lang->line('add') .' '. $this->lang->line('news'); ?></a></h1>
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
                            <option value="1">Active</option>
                            <option value="0">IN Active</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('news_start_date'); ?></label>
                    <div>
                        <input type="text" id="start_date" class="form-control date-picker" placeholder="From Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('news_end_date'); ?></label>
                    <div>
                        <input type="text" id="end_date" class="form-control date-picker" placeholder="To Date">
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
                        <th><?php echo $this->lang->line('news_name'); ?></th>
                        <th width="100"><?php echo $this->lang->line('news_start_date'); ?></th>
                        <th width="100"><?php echo $this->lang->line('news_end_date'); ?></th>
                        <th width="100"><?php echo $this->lang->line('status'); ?></th>
                        <th width="100"><?php echo $this->lang->line('actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5"><i><?php echo $this->lang->line('loading'); ?></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>