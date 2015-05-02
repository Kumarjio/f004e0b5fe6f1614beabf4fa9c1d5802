<?php 
    $session = $this->session->userdata('user_session');
?>
<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();

        jQuery('#product_category').change(function(){
            loadDatatable();    
        });

        jQuery('#market_id').change(function(){
            loadDatatable();    
        });

        jQuery('#market_id').change(function(){
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo USER_URL ."get_product_category_by_market/"; ?>' + $('#market_id').val(),
                success: function(data){
                    jQuery('#product_category').empty();
                    jQuery('#product_category').append(data);
                    jQuery("#product_category").trigger("chosen:updated");
                }
            });
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
                {"sClass": ""},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'product/getjson?market_id='; ?>" + jQuery('#market_id').val() + '&product_category=' + jQuery('#product_category').val(),
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
                        url: http_host_js + 'product/delete/' + current_id,
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
            <h1><?php echo $this->lang->line('list') ,' ', $this->lang->line('product'); ?></h1>
        </div>
    </div>

    <?php if (hasPermission('product', 'addProduct')) { ?>
        <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
            <div class="page-header text-right">
                <h1><a class="btn btn-green" href="<?php echo USER_URL . 'product/add'; ?>" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('add'); ?>"><i class="clip-plus-circle"></i>&nbsp;<?php echo $this->lang->line('add') .' '. $this->lang->line('product'); ?></a></h1>
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
            <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('markets'); ?></label>
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

            <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang->line('product_category'); ?></label>
                    <div>
                        <select id="product_category" class="form-control chosen-select">
                            <option value="null">All</option>                     
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
                        <th width="125"><?php echo $this->lang->line('markets'); ?></th>
                        <th width="125"><?php echo $this->lang->line('product_category'); ?></th>
                        <th><?php echo $this->lang->line('product_name'); ?></th>
                        <th width="150"><?php echo $this->lang->line('product_image'); ?></th>
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