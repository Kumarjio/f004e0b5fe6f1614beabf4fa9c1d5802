<?php $session = $this->session->userdata('user_session'); ?>
<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();
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
                {"sClass": ""},{"sClass": ""},{"sClass": ""},{"sClass": "text-center"},
                {"sClass": "text-center"},{"sClass": "text-center"},
                {"sClass": "text-center"},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'productrate/getjson'; ?>",
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
                        url: http_host_js + 'productrate/delete/' + current_id,
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
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('list') ,' ', $this->lang->line('product_rate'); ?></h1>
        </div>
    </div>
</div>
<?php if (hasPermission('product_rates', 'addProductrate')) { ?>
    <div class="row">
        <div class="col-sm-12">
                <a class="pull-right btn btn-green" href="<?php echo USER_URL . 'productrate/add'; ?>" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('add'); ?>"><i class="clip-plus-circle"></i>&nbsp;<?php echo $this->lang->line('add') .' '. $this->lang->line('product_rate'); ?></a>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-sm-12">
        &nbsp;
    </div>
</div>


<div id="mainpanel" class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead class="the-box dark full">
            <tr align="left">
                <th width="150"><?php echo $this->lang->line('market_name'); ?></th>
                <th><?php echo $this->lang->line('product_category_name'); ?></th>
                <th><?php echo $this->lang->line('product_name'); ?></th>
                <th width="125"><?php echo $this->lang->line('product_rate_min'); ?></th>
                <th width="125"><?php echo $this->lang->line('product_rate_max'); ?></th>
                <th width="125"><?php echo $this->lang->line('product_rate_income'); ?></th>
                <th width="125"><?php echo $this->lang->line('product_rate_date'); ?></th>
                <th width="100"><?php echo $this->lang->line('actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="8"><i><?php echo $this->lang->line('loading'); ?></i></td>
            </tr>
        </tbody>
    </table>
</div>