<script type="text/javascript">
    $(document).ready(function(){
        //get_total_count();
    });

    function get_total_count(){
        $.ajax({
            type : 'POST',
            url : http_host_js + 'get_dashboard_count',
            dataType : 'JSON',
            success: function(data) {
                if(data != ''){
                    jQuery('#total_bussiness_categories').html(data.total_counts.total_bussiness_categories);
                    jQuery('#total_bussiness_sub_categories').html(data.total_counts.total_bussiness_sub_categories);
                    jQuery('#total_compaines').html(data.total_counts.total_compaines);
                    jQuery('#total_urls').html(data.total_counts.total_urls);
                    jQuery('#total_leads').html(data.total_counts.total_leads);
                } else {
                    jQuery('#total_bussiness_categories').html('0');
                    jQuery('#total_bussiness_sub_categories').html('0');
                    jQuery('#total_compaines').html('0');
                    jQuery('#total_urls').html('0');
                    jQuery('#total_leads').html('0');
                }

                setTimeout(function() {
                    get_total_count();
                }, <?php echo $this->config->item('notification_timer'); ?>);

            }
        });
    }    
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1>Dashboard</h1>
        </div>
    </div>
</div>