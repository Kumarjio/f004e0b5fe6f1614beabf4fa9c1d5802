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
                {"sClass": ""},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'page/getjson'; ?>",
        });
    }
</script>

<div class="row">
    <div class="col-sm-12 col-sm-6 col-md-6 col-lg-6">
        <div class="page-header">
            <h1><?php echo $this->lang->line('list') ,' ', $this->lang->line('page'), ' ('. @$count .')'; ?></h1>
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
                        <th><?php echo $this->lang->line('page_content_title'); ?></th>
                        <th width="100"><?php echo $this->lang->line('actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"><i><?php echo $this->lang->line('loading'); ?></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>