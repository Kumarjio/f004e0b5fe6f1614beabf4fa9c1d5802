<?php $session = $this->session->userdata('user_session'); ?>
<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();

        jQuery('#role_id').change(function(){
            loadDatatable();    
        });

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
                {"sClass": "text-center"},{"sClass": ""},{"sClass": ""},{"sClass": ""},{"sClass": "text-center"},
                {"sClass": "text-center"},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'user/getjson?status='; ?>" + jQuery('#status').val() + '&role_id=' + jQuery('#role_id').val(),
        });
    }

</script>

<div class="row">
    <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
        <div class="page-header">
            <h1><?php echo $this->lang->line('list') ,' ', $this->lang->line('user'), ' ('. @$count .')'; ?></h1>
        </div>
    </div>

    <?php if (hasPermission('users', 'addUser')) { ?>
        <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
            <div class="page-header text-right">
                <h1><a class="btn btn-green" href="<?php echo USER_URL . 'user/add'; ?>" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('add'); ?>"><i class="clip-plus-circle"></i>&nbsp;<?php echo $this->lang->line('add') .' '. $this->lang->line('supplier'); ?></a></h1>
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
                    <label class="control-label"><?php echo $this->lang->line('user_status'); ?></label>
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
                    <label class="control-label"><?php echo $this->lang->line('user_role'); ?></label>
                    <div>
                        <select id="role_id" class="form-control chosen-select">
                            <option value="null">All</option>
                            <?php foreach ($roles as $role) { ?>
                                <option value="<?php echo $role->id; ?>"><?php echo ucwords($role->name); ?></option>
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
                        <th width="125"><?php echo $this->lang->line('user_image'); ?></th>
                        <th><?php echo $this->lang->line('user_name'); ?></th>
                        <th width="100"><?php echo $this->lang->line('user_username'); ?></th>
                        <th width="125"><?php echo $this->lang->line('user_role'); ?></th>
                        <th width="125"><?php echo $this->lang->line('user_mobile'); ?></th>
                        <th width="100"><?php echo $this->lang->line('user_status'); ?></th>
                        <th width="75"><?php echo $this->lang->line('actions'); ?></th>
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