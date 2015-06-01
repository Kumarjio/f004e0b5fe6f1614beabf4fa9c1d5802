<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery("#add").validate();

            jQuery('#market_fee').change(function(){
                statisticalDataBalance();                
            });

            jQuery('#license_fee').change(function(){
                statisticalDataBalance();                
            });

            jQuery('#other_income').change(function(){
                statisticalDataBalance();                
            });

            jQuery('#expenses').change(function(){
                statisticalDataBalance();                
            });
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('add') ,' ', $this->lang->line('statistical_data'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'statistic/add'; ?>">
            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_from_year'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="from_year" class="form-control required" placeholder="<?php echo $this->lang->line('statistics_from_year'); ?>" min="0" maxlength="4" minlength="4"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_to_year'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="to_year" class="form-control required" placeholder="<?php echo $this->lang->line('statistics_to_year'); ?>" min="0" maxlength="4" minlength="4"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_market_fee'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="market_fee" id="market_fee" class="form-control required income" placeholder="<?php echo $this->lang->line('statistics_market_fee'); ?>" min="0" />
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_license_fee'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="license_fee" id="license_fee" class="form-control required income" placeholder="<?php echo $this->lang->line('statistics_license_fee'); ?>" min="0" />
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_other_income'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="other_income" id="other_income" class="form-control required income" placeholder="<?php echo $this->lang->line('statistics_other_income'); ?>" min="0" />
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_total_income'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="total_income" id="total_income" class="form-control" placeholder="<?php echo $this->lang->line('statistics_total_income'); ?>" readonly="readonly"  min="0" />
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_total_expenses'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="total_expenses" id="expenses" class="form-control required" placeholder="<?php echo $this->lang->line('statistics_total_expenses'); ?>" min="0"/>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('statistics_fund_left'); ?>
                    <span class="text-danger">&nbsp;</span>
                </label>
                <div class="col-lg-9">
                    <input type="number" name="fund_left" id="balance" class="form-control" placeholder="<?php echo $this->lang->line('statistics_fund_left'); ?>" readonly="readonly"  min="0" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('add'); ?>"><?php echo $this->lang->line('add'); ?></button>
                    <a href="<?php echo USER_URL . 'statistic' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <?php echo $this->lang->line('compulsory_note'); ?>
                </div>
            </div>
        </form>
    </div>
</div>
