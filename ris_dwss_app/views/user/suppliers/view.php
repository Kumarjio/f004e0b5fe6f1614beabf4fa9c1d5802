<?php $session = $this->session->userdata('user_session'); ?>
<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();

        jQuery('#market_id').change(function(){
            loadDatatable();    
        });

        jQuery('#suppliertype_id').change(function(){
            loadDatatable();    
        });

        jQuery('#supplierbusinesstype_id').change(function(){
            loadDatatable();    
        });

        jQuery('#supplieramenity_id').change(function(){
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
                {"sClass": ""},{"sClass": ""},{"sClass": ""},{"sClass": ""},{"sClass": ""},
                {"sClass": ""},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'supplier/getjson?market_id='; ?>" + jQuery('#market_id').val() + '&suppliertype_id=' + jQuery('#suppliertype_id').val() + '&supplierbusinesstype_id=' + jQuery('#supplierbusinesstype_id').val() + '&supplieramenity_id=' + jQuery('#supplieramenity_id').val(),
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
                        url: http_host_js + 'supplier/delete/' + current_id,
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
            <h1><?php echo $this->lang->line('list') ,' ', $this->lang->line('supplier'); ?></h1>
        </div>
    </div>

    <?php if (hasPermission('suppliers', 'addSupplier')) { ?>
        <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
            <div class="page-header text-right">
                <h1><a class="btn btn-green" href="<?php echo USER_URL . 'supplier/add'; ?>" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('add'); ?>"><i class="clip-plus-circle"></i>&nbsp;<?php echo $this->lang->line('add') .' '. $this->lang->line('supplier'); ?></a></h1>
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
            <div class="col-sm-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('supplier_market'); ?></label>
                    <div>
                        <select id="market_id" class="form-control chosen-select">
                            <option value="null">All</option>
                            <?php foreach ($markets as $market) { ?>
                                <option value="<?php echo $market->id; ?>"><?php echo ucwords($market->{$session->language.'_name'}); ?></option>
                            <?php } ?>                        
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('supplier_type'); ?></label>
                    <div>
                        <select id="suppliertype_id" class="form-control chosen-select">
                            <option value="null">All</option>
                            <?php foreach ($suppliertypes as $suppliertype) { ?>
                                <option value="<?php echo $suppliertype->id; ?>"><?php echo ucwords($suppliertype->{$session->language.'_name'}); ?></option>
                            <?php } ?>                        
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('supplier_bussiness_type'); ?></label>
                    <div>
                        <select id="supplierbusinesstype_id" class="form-control chosen-select">
                            <option value="null">All</option>
                            <?php foreach ($supplierbusinesstypes as $supplierbusinesstype) { ?>
                                <option value="<?php echo $supplierbusinesstype->id; ?>"><?php echo ucwords($supplierbusinesstype->{$session->language.'_name'}); ?></option>
                            <?php } ?>                        
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('supplier_amenities'); ?></label>
                    <div>
                        <select id="supplieramenity_id" class="form-control chosen-select">
                            <option value="null">All</option>
                            <?php foreach ($supplieramenities as $supplieramenitie) { ?>
                                <option value="<?php echo $supplieramenitie->id; ?>"><?php echo ucwords($supplieramenitie->{$session->language.'_name'}); ?></option>
                            <?php } ?>                        
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
                        <th><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="125"><?php echo $this->lang->line('supplier_shop_name'); ?></th>
                        <th width="100"><?php echo $this->lang->line('supplier_market'); ?></th>
                        <th width="125"><?php echo $this->lang->line('supplier_type'); ?></th>
                        <th width="125"><?php echo $this->lang->line('supplier_bussiness_type'); ?></th>
                        <th width="125"><?php echo $this->lang->line('supplier_amenities'); ?></th>
                        <th width="125"><?php echo $this->lang->line('actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7"><i><?php echo $this->lang->line('loading'); ?></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>