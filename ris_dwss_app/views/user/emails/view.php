<script type="text/javascript" >
    jQuery(document).ready(function() {
        jQuery('#list_data').dataTable({
            "bProcessing": true,
            "aLengthMenu": [ [<?php echo $this->config->item('data_table_length'); ?>], [<?php echo $this->config->item('data_table_length'); ?>] ],
            'iDisplayLength': <?php $lengths = explode(',', $this->config->item('data_table_length'));
            echo $lengths[0]; ?>,
            "bServerSide" : true,
            "aoColumns": [
                {"sClass": ""},{"bSortable": false, "sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo USER_URL . 'email/getjson'; ?>",
        });
    });

</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1>Email Templates</h1>
        </div>
    </div>
</div

<div class="box-body table-responsive">
    <table class="table table-bordered table-hover" id="list_data">
        <thead>
            <tr align="left">
                <th>Subject</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                 <td colspan="2"><i>Loading...</i></td>
            </tr>
        </tbody>
    </table>
</div>